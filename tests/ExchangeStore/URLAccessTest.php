<?php
namespace Pex;
/**
 * Test class for URLAccess.
 * Generated by PHPUnit on 2010-04-26 at 13:59:06.
 */
class URLAccessTest extends PexTestBase {
    /**
     * @var URLAccess
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp() {
        $this->object = new URLAccess();
    }


    /**
     * Test that the correct values are set
     *
     * @retrun void;
     */
    public function testSetCustomUrls() {
        $urls           = new StoreUrlData();
        $urls->inbox    = 'inbox1';
        $urls->calendar = 'calendar1';
        $urls->contacts = 'contacts1';
        $urls->notes    = 'notes1';
        $urls->tasks    = 'tasks1';

        $this->object->setCustomUrls($urls);
        
        $this->assertEquals(
            $this->object->inbox,
            $urls->inbox,
            'The inbox in the URLAccess is not the same as in the StoreUrlData'
                );
        $this->assertEquals(
            $this->object->calendar,
            $urls->calendar,
            'The calendar in the URLAccess is not the same as in the StoreUrlData'
            );
        $this->assertEquals(
            $this->object->contacts,
            $urls->contacts,
            'The contacts in the URLAccess is not the same as in the StoreUrlData');
        $this->assertEquals(
            $this->object->notes,
            $urls->notes,
            'The notes in the URLAccess is not the same as in the StoreUrlData');
        $this->assertEquals(
            $this->object->tasks,
            $urls->tasks,
            'The tasks in the URLAccess is not the same as in the StoreUrlData');


    }
}
?>
