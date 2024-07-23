<?php

namespace Behat\Mink\Tests\Driver\Custom;

use Behat\Mink\Tests\Driver\TestCase;

class LargePageClickTest extends TestCase
{
    public function testLargePageClick(): void
    {
        $this->getSession()->visit($this->pathTo('/multi_input_form.html'));

        // Add a large amount of br tags so that the button is not in view.
        $large_page = str_repeat('<br />', 2000);
        $script = <<<JS
            const p = document.createElement("div");
            p.innerHTML = "$large_page";
            document.body.insertBefore(p, document.body.firstChild);
        JS;
        $this->getSession()->executeScript($script);

        $page = $this->getSession()->getPage();
        $page->pressButton('Register');
        $this->assertStringContainsString('no file', $page->getContent());
    }
}
