document.addEventListener('DOMContentLoaded', function() {
    fetch('https://api.alternative.me/fng/')
    .then(response => response.json())
    .then(data => {
        const indexData = data.data[0];
        const indexValue = parseInt(indexData.value, 10);
        document.getElementById('indexValue').textContent = indexValue;
        const label = document.getElementById('index-label');

        if (indexValue < 20) {
            label.textContent = 'Extreme Fear';
        } else if (indexValue < 40) {
            label.textContent = 'Fear';
        } else if (indexValue < 60) {
            label.textContent = 'Neutral';
        } else if (indexValue < 80) {
            label.textContent = 'Greed';
        } else {
            label.textContent = 'Extreme Greed';
        }

        // SVG üzerinde dairenin konumunu ayarla
        const indicator = document.getElementById('indicator');
        const svgWidth = 177; // SVG'nin genişliği
        const maxIndexValue = 100;
        const normalizedValue = (indexValue / maxIndexValue) * svgWidth;
        indicator.setAttribute('cx', normalizedValue);
    })
    .catch(error => console.error('Error fetching data:', error));
});



