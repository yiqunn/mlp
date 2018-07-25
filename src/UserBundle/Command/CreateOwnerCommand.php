<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


// command used to create new owner
class CreateOwnerCommand extends ContainerAwareCommand {

    protected function configure() {
        $this->setName('mlp:createOwner')
            ->setDescription("create new owner.")
	    ->addArgument(
			  'name',
			  InputArgument::REQUIRED,
			    'name of the owner'
			  )
	    ->addArgument(
			  'phoneNumber',
			  InputArgument::REQUIRED,
			    'phone number of the owner'
			  )
	    ->addArgument(
			  'email',
			  InputArgument::REQUIRED,
			    'email of the owner'
			  )
	    ->addArgument(
			  'permission',
			  InputArgument::OPTIONAL,
			    'permission of the owner'
			  );

    }



    protected function execute(InputInterface $input,

			       OutputInterface $output) {

	// get all arguments
	$name = $input->getArgument('name');
	$phoneNumber = $input->getArgument("phoneNumber");
	$email = $input->getArgument("email");
	$permission = $input->getArgument("permission");	

	// go ahead to create user
	$userMgr = $this->getContainer()->get('user_manager');
	$userMgr->createOwner($name, $phoneNumber, $email, $permission);
	$output->writeln("<info>CreateOwner completed.</info>");

    }

} // CreateOwnerCommand
