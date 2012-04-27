<?php
/**
 * User: quanmt
 * Date: 4/27/12
 * Time: 10:52 AM
 */

class TestController extends AppController
{
    var $metalTypes = array(
        'gold',
        'plat',
        'silv',
    );
    var $uses = array(
        'Test', 'Metal',
    );

    /**
     * Create new test
     */
    public function newTest()
    {
        $this->Test->save();
    }

    /**
     * Update metal price
     * @param $type
     * @param $price
     */
    public function updateMetal($type, $price)
    {
        $test = $this->Test->find('first', array(
                'order' => 'created DESC',
            ));

        if (!$test) {
            $this->newTest();
            $test = $this->Test->find('first');
        }

        $data = array(
            'Metal' => array(
                'test_id' => $test['Test']['id'],
                'type' => $type,
                'price' => $price,
            ),
        );

        $this->Metal->save($data);

        $this->set(array(
                'type' => $type,
                'price' => $price,
            ));
    }

    public function charts($id = null)
    {
        $tests = $this->Test->find('all');
        foreach($tests as $key => $test) {
            if (!count($tests[$key])) {
                unset($tests[$key]);
            }
        }

        $this->set('tests', $tests);

        // chart
        if ($id) {
            $test = $this->Test->findByid($id);
            $metals = array();
            foreach ($this->metalTypes as $type) {
                    $metals[$type] = $this->Metal->find('all', array(
                            'conditions' => array(
                                'type' => $type,
                                'test_id' => $id,
                            ),
                            'order' => 'Metal.created ASC',
                        ));
            }

            $this->set(array(
                    'test' => $test,
                    'metals' => $metals,
                ));
        }
    }
}
