<?php
class Comment extends ORM
{
	public $User;

    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('comments');

        if ($id != null) {
            $this->populate($id);
        }
    }

    public function create($userId, $postId, $content)
    {
    	$this->addInsertFields('user_id', $userId, PDO::PARAM_INT);
        $this->addInsertFields('post_id', $postId, PDO::PARAM_INT);
        $this->addInsertFields('content', $content, PDO::PARAM_STR);
        $this->addInsertFields('created', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        
        $newId = $this->insert();
        $this->populate($newId);
    }

	public function commentsFromPost($postId, $limit = 2)
    {
    	$this->addWhereFields('post_id', $postId, '=', PDO::PARAM_INT);
    	$this->setSelectFields('id');
    	$this->addOrder('created', 'ASC');
    	$this->setLimit($limit);
    	$comments = $this->get('all');

    	$commentsComplete = [];

    	foreach ($comments as $comment) {
    		$commentsComplete[] = new Comment($comment->id);
    	}

    	return $commentsComplete;
    }

    public function nbCommentsOfPost($postId)
    {
    	$this->addWhereFields('post_id', $postId, '=', PDO::PARAM_INT);
        return $this->get('count');
    }

    public function lastCommentsOfUser($userId)
    {
        $this->addWhereFields('user_id', $userId, '=', PDO::PARAM_INT);
    	$this->setSelectFields('id');
    	$this->addOrder('created', 'ASC');
    	$this->setLimit(10);
    	$comments = $this->get('all');

    	$commentsComplete = [];

    	foreach ($comments as $comment) {
            $comment = new Comment($comment->id);
            $comment->loadPost();
            $commentsComplete[] = $comment; 
    	}

    	return $commentsComplete;
    }

    public function populate($id)
    {
        if (parent::populate($id)) {
            $this->User = new User($this->user_id);
        }
    }

    public function loadPost()
    {
        $this->Post = new Post($this->post_id);
    }

    public function allCommentCreate()
    {
        return $this->get(TYPE_GET_COUNT);

    }

    public function moreCommentPost()
    {
        $this->setSelectFields('id');
        $comments = $this->get('all');

        $arrayComments = array_fill(0, 10 ,$comments);

        //return array_count_values($arrayComments);
    }
}