<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code',TextType::class,[
                'label'=>'Codigo',
                'attr'=>['class'=>'form-control']
            ])
            ->add('name',TextType::class,[
                'label'=>'Nombre',
                'attr'=>['class'=>'form-control']
            ])
            ->add('description',TextType::class,[
                'label'=>'Descripcion',
                'attr'=>['class'=>'form-control']
            ])
            ->add('brand',TextType::class,[
                'label'=>'Marca',
                'attr'=>['class'=>'form-control']
            ])
            ->add('price',NumberType::class,[
                'label'=>'Precio',
                'attr'=>['class'=>'form-control']
            ])            
            ->add('category', EntityType::class , [
                'attr'=>['class'=>'form-control'],
                'class'=>Category::class,
                'choice_label'=>function($category){
                    return $category->getname();
                }
            ])
            ->add('Guardar', SubmitType::class ,[
                'attr'=>['class'=>'btn btn-success']
            ])  
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
