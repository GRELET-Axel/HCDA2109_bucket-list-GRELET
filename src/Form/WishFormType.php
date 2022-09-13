<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class WishFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,['attr'=>['class'=>'form-input']])
            ->add('description',TextareaType::class,['attr'=>['class'=>'form-input']])
            ->add('author',TextType::class,['attr'=>['class'=>'form-input']])
            ->add('category',EntityType::class,[

                'class'=>Category::class,
                'query_builder'=> function (EntityRepository $er){
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => 'name',
                ])
            ->add('save', SubmitType::class, ['label' => 'SAVE'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
