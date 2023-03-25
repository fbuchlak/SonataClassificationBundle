.. index::
    single: Installation
    single: Configuration

Installation
============

Prerequisites
-------------

There are some Sonata dependencies that need to be installed and configured beforehand.

Optional dependencies:

* `SonataAdminBundle <https://docs.sonata-project.org/projects/SonataAdminBundle/en/3.x/>`_
* `SonataBlockBundle <https://docs.sonata-project.org/projects/SonataBlockBundle/en/3.x/>`_
* `SonataMediaBundle <https://docs.sonata-project.org/projects/SonataMediaBundle/en/3.x/>`_

And the persistence bundle (choose one):

* `SonataDoctrineOrmAdminBundle <https://docs.sonata-project.org/projects/SonataDoctrineORMAdminBundle/en/3.x/>`_
* `SonataDoctrineMongoDBAdminBundle <https://docs.sonata-project.org/projects/SonataDoctrineMongoDBAdminBundle/en/3.x/>`_

Follow also their configuration step; you will find everything you need in
their own installation chapter.

.. note::

    If a dependency is already installed somewhere in your project or in
    another dependency, you won't need to install it again.

Enable the Bundle
-----------------

Add ``SonataClassificationBundle`` via composer::

    composer require sonata-project/classification-bundle

Next, be sure to enable the bundles in your ``config/bundles.php`` file if they
are not already enabled::

    // config/bundles.php

    return [
        // ...
        Sonata\ClassificationBundle\SonataClassificationBundle::class => ['all' => true],
    ];

Configuration
=============

SonataClassificationBundle Configuration
----------------------------------------

.. code-block:: yaml

    # config/packages/sonata_classification.yaml

    sonata_classification:
        class:
            tag: App\Entity\SonataClassificationTag
            category: App\Entity\SonataClassificationCategory
            collection: App\Entity\SonataClassificationCollection
            context: App\Entity\SonataClassificationContext

Doctrine ORM Configuration
--------------------------

Add these bundles in the config mapping definition (or enable `auto_mapping`_)::

    # config/packages/doctrine.yaml

    doctrine:
        orm:
            entity_managers:
                default:
                    mappings:
                        SonataClassificationBundle: ~

And then create the corresponding entities, ``src/Entity/SonataClassificationTag``::

    // src/Entity/SonataClassificationTag.php

    use Doctrine\DBAL\Types\Types;
    use Doctrine\ORM\Mapping as ORM;
    use Sonata\ClassificationBundle\Entity\BaseTag;

    #[ORM\Entity]
    #[ORM\Table(name: 'classification__tag')]
    class SonataClassificationTag extends BaseTag
    {
        #[ORM\Id]
        #[ORM\Column(type: Types::INTEGER)]
        #[ORM\GeneratedValue]
        protected ?int $id = null;

        public function getId(): ?int
        {
            return $this->id;
        }
    }

``src/Entity/SonataClassificationCategory``::

    // src/Entity/SonataClassificationCategory.php

    use Doctrine\DBAL\Types\Types;
    use Doctrine\ORM\Mapping as ORM;
    use Sonata\ClassificationBundle\Entity\BaseCategory;

    #[ORM\Entity]
    #[ORM\Table(name: 'classification__category')]
    class SonataClassificationCategory extends BaseCategory
    {
        #[ORM\Id]
        #[ORM\Column(type: Types::INTEGER)]
        #[ORM\GeneratedValue]
        protected ?int $id = null;

        public function getId(): ?int
        {
            return $this->id;
        }
    }

``src/Entity/SonataClassificationCollection``::

    // src/Entity/SonataClassificationCollection.php

    use Doctrine\DBAL\Types\Types;
    use Doctrine\ORM\Mapping as ORM;
    use Sonata\ClassificationBundle\Entity\BaseCollection;

    #[ORM\Entity]
    #[ORM\Table(name: 'classification__collection')]
    class SonataClassificationCollection extends BaseCollection
    {
        #[ORM\Id]
        #[ORM\Column(type: Types::INTEGER)]
        #[ORM\GeneratedValue]
        protected ?int $id = null;

        public function getId(): ?int
        {
            return $this->id;
        }
    }

and ``src/Entity/SonataClassificationContext``::

    // src/Entity/SonataClassificationContext.php

    use Doctrine\DBAL\Types\Types;
    use Doctrine\ORM\Mapping as ORM;
    use Sonata\ClassificationBundle\Entity\BaseContext;

    #[ORM\Entity]
    #[ORM\Table(name: 'classification__context')]
    class SonataClassificationContext extends BaseContext
    {
        #[ORM\Id]
        #[ORM\Column(type: Types::STRING)]
        protected ?string $id = null;
    }

The only thing left is to update your schema::

    bin/console doctrine:schema:update --force

Doctrine MongoDB Configuration
------------------------------

You have to create the corresponding documents, ``src/Document/SonataClassificationTag``::

    // src/Document/SonataClassificationTag.php

    use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
    use Sonata\ClassificationBundle\Document\BaseTag;

    #[ODM\Document]
    class SonataClassificationTag extends BaseTag
    {
        #[ODM\Id]
        protected $id;
    }

``src/Document/SonataClassificationCategory``::

    // src/Document/SonataClassificationCategory.php

    use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
    use Sonata\ClassificationBundle\Document\BaseCategory;

    #[ODM\Document]
    class SonataClassificationCategory extends BaseCategory
    {
        #[ODM\Id]
        protected $id;
    }

``src/Document/SonataClassificationCollection``::

    // src/Document/SonataClassificationCollection.php

    use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
    use Sonata\ClassificationBundle\Document\BaseCollection;

    #[ODM\Document]
    class SonataClassificationCollection extends BaseCollection
    {
        #[ODM\Id]
        protected $id;
    }

and ``src/Document/SonataClassificationContext``::

    // src/Document/SonataClassificationContext.php

    use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
    use Sonata\ClassificationBundle\Document\BaseContext;

    #[ODM\Document]
    class SonataClassificationContext extends BaseContext
    {
        #[ODM\Id]
        protected $id;
    }

And then configure ``ClassificationBundle`` to use the newly generated classes::

    # config/packages/sonata_classification.yaml

    sonata_classification:
        class:
            tag: App\Document\SonataClassificationTag
            category: App\Document\SonataClassificationCategory
            collection: App\Document\SonataClassificationCollection
            context: App\Document\SonataClassificationContext

Next Steps
----------

At this point, your Symfony installation should be fully functional, without errors
showing up from SonataClassificationBundle. If, at this point or during the installation,
you come across any errors, don't panic:

    - Read the error message carefully. Try to find out exactly which bundle is causing the error.
      Is it SonataClassificationBundle or one of the dependencies?
    - Make sure you followed all the instructions correctly, for both SonataClassificationBundle and its dependencies.
    - Still no luck? Try checking the project's `open issues on GitHub`_.

.. _`open issues on GitHub`: https://github.com/sonata-project/SonataClassificationBundle/issues
.. _`auto_mapping`: http://symfony.com/doc/4.4/reference/configuration/doctrine.html#configuration-overviews
