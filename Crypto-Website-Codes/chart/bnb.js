const chartProperties = {
    width: 1500,
    height: 600,
    timeScale: {
        timeVisible: true,
        secondsVisible: false,
    }
};
const domElement = document.getElementById('tvchart');
const chart = LightweightCharts.createChart(domElement, chartProperties);
const candleSeries = chart.addCandlestickSeries();

let initialData = null; // İlk yüklendiğinde veriyi saklamak için

function changeInterval(interval) {
    let limit, intervalTime;
    switch(interval) {
        case '1m':
            limit = 20160; // 2 hafta boyunca 1 dakikalık veri (14 gün * 1440 dakika)
            intervalTime = '1m';
            break;
        case '15m':
            limit = 672; // 7 gün boyunca 15 dakikalık veri (7 gün * 96)
            intervalTime = '15m';
            break;
        case '1h':
            limit = 168; // 7 gün boyunca saatlik veri (7 gün * 24)
            intervalTime = '1h';
            break;
        default:
            limit = 672;
            intervalTime = '15m';
    }

    fetch(`https://api.binance.com/api/v3/klines?symbol=BNBUSDT&interval=${intervalTime}&limit=${limit}`)
        .then(res => res.json())
        .then(data => {
            const cdata = data.map(d => ({
                time: d[0] / 1000,
                open: parseFloat(d[1]),
                high: parseFloat(d[2]),
                low: parseFloat(d[3]),
                close: parseFloat(d[4]),
                volume: parseFloat(d[5])
            }));
            candleSeries.setData(cdata);

            if (!initialData) {
                initialData = cdata;
                calculateAndDisplayChanges(initialData);
            }
        })
        .catch(err => console.log(err));
}

function updateChartData(interval) {
    let limit, intervalTime;
    switch(interval) {
        case '1m':
            limit = 20160;
            intervalTime = '1m';
            break;
        case '15m':
            limit = 672;
            intervalTime = '15m';
            break;
        case '1h':
            limit = 168;
            intervalTime = '1h';
            break;
        default:
            limit = 672;
            intervalTime = '15m';
    }

    fetch(`https://api.binance.com/api/v3/klines?symbol=BNBUSDT&interval=${intervalTime}&limit=${limit}`)
        .then(res => res.json())
        .then(data => {
            const cdata = data.map(d => ({
                time: d[0] / 1000,
                open: parseFloat(d[1]),
                high: parseFloat(d[2]),
                low: parseFloat(d[3]),
                close: parseFloat(d[4]),
                volume: parseFloat(d[5])
            }));
            candleSeries.setData(cdata);
            calculateAndDisplayChanges(cdata);
        })
        .catch(err => console.log(err));
}

function calculateAndDisplayChanges(data) {
    if (data.length > 0) {
        const latestPrice = data[data.length - 1].close;
        const volume = data[data.length - 1].volume;
        const price1hAgo = initialData[Math.max(initialData.length - 60, 0)].close; // 1 saat önceki fiyat
        const price24hAgo = initialData[Math.max(initialData.length - 1440, 0)].close; // 24 saat önceki fiyat
        const price7DaysAgo = initialData[Math.max(initialData.length - 10080, 0)].close; // 7 gün önceki fiyat

        const change1h = ((latestPrice - price1hAgo) / price1hAgo) * 100;
        const change24h = ((latestPrice - price24hAgo) / price24hAgo) * 100;
        const change7d = ((latestPrice - price7DaysAgo) / price7DaysAgo) * 100;

        updateChangeDisplay('livePrice', latestPrice.toFixed(2) + ' USDT');
        updateChangeDisplay('volume', 'Volume: ' + volume.toFixed(2));
        updateChangeDisplay('hourlyChange', `1h Change: ${change1h.toFixed(2)}%`, change1h);
        updateChangeDisplay('dailyChange', `24h Change: ${change24h.toFixed(2)}%`, change24h);
        updateChangeDisplay('weeklyChange', `7d Change: ${change7d.toFixed(2)}%`, change7d);
    }
}

function updateChangeDisplay(elementId, text, change = null) {
    const element = document.getElementById(elementId);
    element.textContent = text;
    if (change !== null) {
        element.className = change >= 0 ? 'positive' : 'negative';
    }
}

// İlk yüklemede varsayılan interval ile verileri yükle
changeInterval('15m');

// Her 1 saniyede bir veriyi yenilemek için setInterval kullanın
setInterval(() => {
    const activeInterval = document.querySelector('.time-buttons button.active')?.getAttribute('data-interval') || '15m';
    updateChartData(activeInterval);
}, 1000); // Her 1 saniyede bir veriyi yeniler

// Butonlara aktif sınıfı eklemek için aşağıdaki kodu ekleyin
document.querySelectorAll('.time-buttons button').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelector('.time-buttons button.active')?.classList.remove('active');
        this.classList.add('active');
        changeInterval(this.getAttribute('data-interval'));
    });
});
