<?php


/**
 * Class Tree
 *
 * @author  geniv
 * @package NetteWeb
 */
abstract class Tree
{
    use \Nette\SmartObject;

    protected $tableTree, $cache;
    /** @var \Dibi\Connection */
    protected $database;


    /**
     * Example constructor.
     *
     * @param                         $tableTree
     * @param \Dibi\Connection        $database
     * @param \Nette\Caching\IStorage $cacheStorage
     */
    public function __construct($tableTree, \Dibi\Connection $database, \Nette\Caching\IStorage $cacheStorage)
    {
        $this->tableTree = $tableTree;
        $this->database = $database;
        $this->cache = new \Nette\Caching\Cache($cacheStorage, 'cache' . str_replace('\\', '', get_class($this)));
    }


    /**
     * nacitani vetve stromu
     *
     * @param $idParent
     * @return mixed
     */
    public function getTreeNode($idParent)
    {
        $items = $this->cache->load('getTreeNode' . $idParent);
        if ($items === null) {
            $item = $this->database->select('id, name, id_parent, [order]')
                ->from($this->tableTree)
                ->orderBy('[order]')->asc();

            // vyber vetve, root nebo podvetev
            if ($idParent) {
                $item = $item->where('id_parent=%i', $idParent);
            } else {
                $item = $item->where('id_parent IS NULL');
            }
            $items = $item->fetchAssoc('id');

            // ulozeni cache
            $this->cache->save('getTreeNode' . $idParent, $items, [
                \Nette\Caching\Cache::TAGS => ['Tree'],
            ]);
        }

        // rekurzivni volani
//        $items = $res;
//        foreach ($res as $rid => $r) {
//            $items[$rid]['items'] = $this->getTreeNode($configure, $rid);
//        }

        return $items;
    }


    /**
     * nacitani koncove vetve stromu
     *
     * @param $id
     * @return \Dibi\Fluent
     */
    public function getTreeItem($id)
    {
        $data = $this->cache->load('getTreeItem' . $id);
        if ($data === null) {
            $data = $this->database->select('id, name, id_parent, [order]')
                ->from($this->tableTree)
                ->where('id=%i', $id)
                ->fetch();

            // ulozeni cache
            $this->cache->save('getTreeItem' . $id, $data, [
                \Nette\Caching\Cache::TAGS => ['Tree'],
            ]);
        }
        return $data;
    }


    /**
     * nacitani listu hoverboxu
     *
     * @param $idParent
     * @return array
     */
    public function getHoverBoxItems($idParent)
    {
        return $this->database->select('i.id, id_menu, content1, content2, content3')
            ->from($this->tableTree . '_item')->as('i')
            ->join($this->tableTree)->as('t')->on('t.id=i.id_menu')
            ->where('t.id_parent=%i', $idParent)
            ->fetchAll();
    }


    /**
     * nacitani detailu hoverboxu
     *
     * @param $id
     * @return \Dibi\Row|FALSE
     */
    public function getHoverBoxDetail($id)
    {
        return $this->database->select('id, id_menu, content1, content2, content3')
            ->from($this->tableTree . '_item')
            ->where('id_menu=%i', $id)
            ->fetch();
    }


    /**
     * nacitani lisitu galerie
     *
     * @param $id
     * @return mixed
     */
    public function getDetailGallery($id)
    {
        return $this->database->select('id, id_menu, name, logo, image1, image2, image3, custom, overlay, [order]')
            ->from($this->tableTree . '_gallery')
            ->where('id_menu=%i', $id)
            ->orderBy('[order]')->asc();
    }
}
