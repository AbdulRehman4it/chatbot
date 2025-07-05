// fetch-image.js
const puppeteer = require('puppeteer');
const fs = require('fs');

const url = process.argv[2];
const outputPath = process.argv[3] || 'output.jpg';

(async () => {
  try {
    const browser = await puppeteer.launch({ headless: true });
    const page = await browser.newPage();
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/114.0.0.0 Safari/537.36');
    await page.goto(url, { waitUntil: 'networkidle2', timeout: 30000 });

    const buffer = await page.screenshot(); // or use response body (see below)
    fs.writeFileSync(outputPath, buffer);

    await browser.close();
  } catch (err) {
    console.error("Puppeteer error:", err);
    process.exit(1);
  }
})();