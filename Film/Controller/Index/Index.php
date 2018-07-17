<?php
namespace Magestore\Film\Controller\Index;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $item=$connection->select()->from(
            ['film_actor' => 'zero_training_four_film_actor'],
            ['film_id']
        )
            ->join(
                ['film'=>'zero_training_four_film'],
                'film.film_id=film_actor.film_id',
                'title'
            )
            ->group('film_id')->having('COUNT(actor_id) >= 5');
        echo'<h2>GET LIST FILMS HAS NUMBER OF ACTOR >=5</h2>';
        $result = $connection->fetchAll($item);
        echo $item;
        \Zend_Debug::dump($result);
        echo '<hr>';

        /****************************************/
        //Get five categories which have number of actor  is highest

        $select = $connection->select()->from(
            ['film'=>'zero_training_four_film']
        )->join(
            array('film_category' =>'zero_training_four_film_category'),
            'film.film_id = film_category.film_id '
        )->joinRight(
            array('film_actor' =>'zero_training_four_film_actor'),
            'film.film_id = film_actor.film_id'
        )->join(
            array('category'=>'zero_training_four_category'),
            'film_category.category_id = category.category_id',
            ["category_name"=>"category.name"]
        )
            ->joinRight(
                array('actor'=>'zero_training_four_actor'),
                'actor.actor_id = film_actor.actor_id',
                ["actor_name" =>"GROUP_CONCAT(first_name,' ', last_name)"]
            )->group('category.category_id');

         echo '<h2>Get five categories which have number of actor  is highest:</h2>';
        $result = $connection->fetchAll($select);
        echo $select;
        \Zend_Debug::dump($result);
            
    }
}