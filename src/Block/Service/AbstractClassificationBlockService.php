<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\ClassificationBundle\Block\Service;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\ClassificationBundle\Model\ContextAwareInterface;
use Sonata\ClassificationBundle\Model\ContextInterface;
use Sonata\ClassificationBundle\Model\ContextManagerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Twig\Environment;

/**
 * @author Christian Gripp <mail@core23.de>
 *
 * @phpstan-import-type FieldDescriptionOptions from \Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface
 *
 * @phpstan-template T of ContextAwareInterface
 */
abstract class AbstractClassificationBlockService extends AbstractBlockService
{
    protected ContextManagerInterface $contextManager;

    public function __construct(Environment $twig, ContextManagerInterface $contextManager)
    {
        parent::__construct($twig);

        $this->contextManager = $contextManager;
    }

    /**
     * @param array<string, mixed> $fieldOptions
     * @param array<string, mixed> $adminOptions
     *
     * @phpstan-param FormMapper<T> $formMapper
     * @phpstan-param AdminInterface<T> $admin
     */
    final protected function getFormAdminType(FormMapper $formMapper, AdminInterface $admin, string $formField, string $field, array $fieldOptions = [], array $adminOptions = []): FormBuilderInterface
    {
        /** @phpstan-var FieldDescriptionOptions $adminOptions */
        $adminOptions = array_merge([
            'edit' => 'list',
            'translation_domain' => 'SonataClassificationBundle',
        ], $adminOptions);

        $fieldDescription = $admin->createFieldDescription($field, $adminOptions);
        $fieldDescription->setAssociationAdmin($admin);

        $fieldOptions = array_merge([
            'sonata_field_description' => $fieldDescription,
            'class' => $admin->getClass(),
            'model_manager' => $admin->getModelManager(),
            'required' => false,
        ], $fieldOptions);

        return $formMapper->create($formField, ModelListType::class, $fieldOptions);
    }

    /**
     * Returns a context choice array.
     *
     * @return array<string, string>
     */
    final protected function getContextChoices(): array
    {
        $contextChoices = [];
        /* @var ContextInterface $context */
        foreach ($this->contextManager->findAll() as $context) {
            $contextChoices[(string) $context->getId()] = (string) $context->getName();
        }

        return $contextChoices;
    }
}
