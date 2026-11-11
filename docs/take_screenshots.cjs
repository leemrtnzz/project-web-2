const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const EDGE_PATH = 'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe';
const BASE_URL = 'http://localhost:8000';
const IMAGES_DIR = path.join(__dirname, 'images');

if (!fs.existsSync(IMAGES_DIR)) {
    fs.mkdirSync(IMAGES_DIR, { recursive: true });
}

async function run() {
    console.log('Launching browser...');
    const browser = await puppeteer.launch({
        executablePath: EDGE_PATH,
        headless: 'new',
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--window-size=1280,850'],
        defaultViewport: { width: 1280, height: 850, deviceScaleFactor: 1.5 }
    });

    const page = await browser.newPage();

    async function snap(filename, url, waitSelector = null, actionBeforeSnap = null) {
        console.log(`Capturing: ${filename} from ${url}`);
        if (url) {
            await page.goto(url, { waitUntil: 'networkidle0', timeout: 30000 });
        }
        if (waitSelector) {
            await page.waitForSelector(waitSelector, { timeout: 10000 });
        }
        if (actionBeforeSnap) {
            await actionBeforeSnap(page);
        }
        await new Promise(r => setTimeout(r, 800));
        const filePath = path.join(IMAGES_DIR, filename);
        await page.screenshot({ path: filePath, fullPage: false });
        console.log(`Saved: ${filePath}`);
    }

    try {
        // 1. Landing Page
        await snap('01_landing_page.png', `${BASE_URL}/`);

        // 2. Login Page
        await snap('02_login_page.png', `${BASE_URL}/login`, 'input[name="email"]');

        // 3. Register Page
        await snap('03_register_page.png', `${BASE_URL}/register`, 'input[name="username"]');

        // 4. Public Profile - Active Creator
        await snap('09_public_profile_active.png', `${BASE_URL}/u/demo`);

        // 5. Public Profile - Banned Creator (DO NOT CROSS)
        await snap('10_public_profile_banned_donotcross.png', `${BASE_URL}/u/violator`);

        // 6. Login as User (demo@example.com)
        await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle0' });
        await page.type('input[name="email"]', 'demo@example.com');
        await page.type('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await page.waitForNavigation({ waitUntil: 'networkidle0' });

        // 7. User Dashboard
        await snap('04_user_dashboard.png', `${BASE_URL}/dashboard`);

        // 8. User Products
        await snap('05_user_products.png', `${BASE_URL}/products`);

        // 9. User Create Product
        await snap('06_user_product_create.png', `${BASE_URL}/products/create`, 'input[name="title"]');

        // 10. User Categories
        await snap('07_user_categories.png', `${BASE_URL}/categories`, 'input[name="name"]');

        // 11. User Profile Edit
        await snap('08_user_profile_edit.png', `${BASE_URL}/profile`, 'input[name="name"]');

        // Logout User
        await page.evaluate(() => {
            const form = document.querySelector('form[action$="/logout"]');
            if (form) form.submit();
        });
        await new Promise(r => setTimeout(r, 1000));

        // 12. Login as Master Admin (master@klikin.id)
        await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle0' });
        await page.type('input[name="email"]', 'master@klikin.id');
        await page.type('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await page.waitForNavigation({ waitUntil: 'networkidle0' });

        // 13. Master Dashboard
        await snap('11_master_dashboard.png', `${BASE_URL}/dashboard`);

        // 14. Master Users Panel
        await snap('12_master_users_panel.png', `${BASE_URL}/admin/users`);

        // 15. Master Ban Modal
        await snap('13_master_ban_modal.png', `${BASE_URL}/admin/users`, null, async (p) => {
            // Click first ban button
            await p.evaluate(() => {
                const banBtn = Array.from(document.querySelectorAll('button')).find(b => b.textContent.includes('Ban'));
                if (banBtn) banBtn.click();
            });
            await new Promise(r => setTimeout(r, 500));
        });

        // 16. Master View Banned Profile with Unban Bar
        await snap('14_master_view_banned_profile.png', `${BASE_URL}/u/violator`);

        // Clear cookies to logout cleanly
        const client = await page.target().createCDPSession();
        await client.send('Network.clearBrowserCookies');
        await new Promise(r => setTimeout(r, 500));

        // 17. Attempt login as Banned User (violator@example.com)
        await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle0' });
        await page.waitForSelector('input[name="email"]');
        await page.type('input[name="email"]', 'violator@example.com');
        await page.type('input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await new Promise(r => setTimeout(r, 1500));
        await snap('15_banned_login_attempt.png', null);

        console.log('All screenshots captured successfully!');
    } catch (err) {
        console.error('Error capturing screenshots:', err);
    } finally {
        await browser.close();
    }
}

run();
