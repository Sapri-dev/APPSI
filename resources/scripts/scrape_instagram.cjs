const puppeteer = require('puppeteer');

(async () => {
    let browser = null;
    try {
        browser = await puppeteer.launch({
            headless: true,
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-gpu'
            ]
        });
        const page = await browser.newPage();
        await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36');
        
        await page.goto('https://www.instagram.com/appsi.or.id/', { 
            waitUntil: 'domcontentloaded', 
            timeout: 25000 
        });
        
        await new Promise(r => setTimeout(r, 3500));
        
        const rawLinks = await page.evaluate(() => {
            const anchors = Array.from(document.querySelectorAll('a[href*="/p/"], a[href*="/reel/"]'));
            return anchors.map(a => a.getAttribute('href'));
        });
        
        const cleanLinks = [];
        const seen = new Set();

        for (const href of rawLinks) {
            if (!href) continue;
            // Match pattern /p/CODE/ or /reel/CODE/
            const match = href.match(/\/(p|reel)\/([a-zA-Z0-9_-]+)/);
            if (match) {
                const type = match[1]; // 'p' or 'reel'
                const code = match[2];
                if (!seen.has(code)) {
                    seen.add(code);
                    cleanLinks.push({
                        type: type,
                        code: code,
                        url: `https://www.instagram.com/${type}/${code}/`,
                        embed_url: `https://www.instagram.com/${type}/${code}/embed/`
                    });
                }
            }
        }
        
        console.log(JSON.stringify({
            status: 'success',
            count: cleanLinks.length,
            posts: cleanLinks.slice(0, 8)
        }));
    } catch (e) {
        console.log(JSON.stringify({
            status: 'error',
            message: e.message,
            posts: []
        }));
    } finally {
        if (browser) {
            await browser.close();
        }
    }
})();
