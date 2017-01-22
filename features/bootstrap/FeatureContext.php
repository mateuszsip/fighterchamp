<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

require_once __DIR__.'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{

    private $output;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @BeforeScenerio
     */
    public function moveIntoTestDir()
    {
        if(!is_dir('test')) {
            mkdir('test');
        }
    }

    /**
     * @AfterScenerio
     */
    public function moveOutOfTestDir()
    {
        chdir('..');
        if(is_dir('test')) {
            system('rm -r'.realpath('test'));
        }
    }


    /**
     * @Given there is a file named :filename
     */
    public function thereIsAFileNamed($filename)
    {
        touch($filename);
    }

    /**
     * @When I run :command
     */
    public function iRun($command)
    {
        $this->output = shell_exec($command);
    }

    /**
     * @Then I should see :arg1 in the output
     */
    public function iShouldSeeInTheOutput($string)
    {

        assertContains(
            $string,
            $this->output,
            sprintf('Did not see "%s" in the output "%s"', $string, $this->output)
        );
    }


}