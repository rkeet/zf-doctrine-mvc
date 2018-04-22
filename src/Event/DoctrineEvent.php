<?php

namespace Keet\Mvc\Event;

use Zend\EventManager\Event;

class DoctrineEvent extends Event
{
    const ENTITY_COLLECTION_PRE_LOAD    = 'entity.collection.pre.load';
    const ENTITY_COLLECTION_POST_LOAD   = 'entity.collection.post.load';
    
    const ENTITY_PRE_LOAD               = 'entity.pre.load';
    const ENTITY_POST_LOAD              = 'entity.post.load';
    
    const ENTITY_ADD_PRE_PERSIST        = 'entity.add.pre.persist';
    const ENTITY_ADD_POST_PERSIST       = 'entity.add.post.persist';
    const ENTITY_ADD_PRE_FLUSH          = 'entity.add.pre.flush';
    const ENTITY_ADD_POST_FLUSH         = 'entity.add.post.flush';

    const ENTITY_EDIT_PRE_PERSIST       = 'entity.edit.pre.persist';
    const ENTITY_EDIT_POST_PERSIST      = 'entity.edit.post.persist';
    const ENTITY_EDIT_PRE_FLUSH         = 'entity.edit.pre.flush';
    const ENTITY_EDIT_POST_FLUSH        = 'entity.edit.post.flush';

    const ENTITY_REMOVE_PRE_PERSIST     = 'entity.remove.pre.persist';
    const ENTITY_REMOVE_POST_PERSIST    = 'entity.remove.post.persist';
    const ENTITY_REMOVE_PRE_FLUSH       = 'entity.remove.pre.flush';
    const ENTITY_REMOVE_POST_FLUSH      = 'entity.remove.post.flush';

}