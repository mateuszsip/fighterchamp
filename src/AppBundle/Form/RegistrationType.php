<?php


namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('plain_password', RepeatedType::class, [
                'type' => PasswordType::class
                ])
            ->add('male', ChoiceType::class, [
                'label' => 'Płeć',
                'placeholder' => 'Wybierz płeć',
                'choices'  => [
                    'Mężczyzna' => 1,
                    'Kobieta' => 0]])
            ->add('name', TextType::class, ['label' => 'Imię'])
            ->add('surname', TextType::class,['label' => 'Nazwisko'])
            ->add('birthDay', BirthdayType::class,[
                'label' => 'Data Urodzenia',
                ])
            ->add('phone', TextType::class, ['label' => 'Telefon'])
            ->add('imageFile', FileType::class,
                ['required' => false])
            ->add('club', TextType::class, [
                'label' => 'Klub (opcjonalnie)',
                'required' => false])
            ->add('terms', CheckboxType::class, array(
                'constraints'=>new IsTrue(array('message'=>'Aby się zarejestrować musisz zaakceptować regulamin')),
                'mapped' => false,
                'label' => ""))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['Default', 'Registration']
        ]);
    }

}