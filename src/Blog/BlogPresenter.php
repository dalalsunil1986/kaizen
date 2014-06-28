<?php namespace Acme\Blog;

use Acme\Core\AbstractPresenter;
use User;

class BlogPresenter extends AbstractPresenter {

    /**
     * Present the created_at property
     * using a different format
     *
     * @param \Acme\Blog\Blog|\User $model
     * @internal param \Kuwaitii\Users\User $user
     * @return \Acme\Blog\BlogPresenter
     */
    public function __construct(Blog $model) {
        $this->resource = $model;
    }

    public function created_at()
    {
        return $this->resource->created_at->format('Y-m-d');
    }

    public function email() {
        return 'haha ' . $this->resource->email;
    }

}
