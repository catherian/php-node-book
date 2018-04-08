import chalk from 'chalk';
import { Builder, until, By } from 'selenium-webdriver';

const log = (err) => console.log(chalk.red(err));

(async () => {
    const driver = await new Builder().forBrowser('chrome').build();

    try {
        await driver.get('http://localhost:8888/index.php?r=site/books');
        await driver.wait(until.elementLocated(By.tagName('td')), 1000);

        console.log(chalk.blue('通过测试'));

    } catch (error) { log(error); }

    await driver.quit();

})();