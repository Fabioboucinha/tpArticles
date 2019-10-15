<?php

namespace App\Form;

use App\Entity\Article;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AdType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class,$this->getConfiguration("Libelle","Tapez ici le titre de votre annonce"))
            ->add('prix', IntegerType::class,$this->getConfiguration("Prix","Tapez ici le prix de votre annonce"))
            ->add('description', TextType::class,$this->getConfiguration("Description","Tapez ici la Description de votre annonce"))
            ->add('image',UrlType::class,$this->getConfiguration("Image de couverture","Tapez ici votre url d'image de couverture"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
