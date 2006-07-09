#!/bin/bash
cd `dirname $0`

case $1 in

	help)
		echo -e "Available Commands:"
		echo -e "\treconfigure: usually useful when you checkout from a versioning system"
		echo -e "\tinitialize: initialize a project"
		echo -e "\trelease: if your project is ready for release, i.e. to be used in a live production server"
		echo -e "\tclean: usually for development purposes only of Hypworks, to ready it for redistribution"
	;;

	reconfigure)
		echo "Creating blank directories..."
		rm -rf `cat .blankdirs`
		mkdir `cat .blankdirs`

		echo "Setting appropriate file permissions..."
		chmod a+wx `cat .writeabledirs`
	;;

	release)
		echo "Creating blank directories..."
		rm -rf `cat .blankdirs`
		mkdir `cat .blankdirs`

		echo "Setting appropriate file permissions..."
		chmod -R go-w .
		chmod a+wx `cat .writeabledirs`

		echo "Removing unnecessary files..."
		find -name ".svn" -exec rm -rf {} \; 2> /dev/null
	;;

	initialize)
		echo "Creating blank directories..."
		rm -rf `cat .blankdirs`
		mkdir `cat .blankdirs`

		echo "Setting appropriate file permissions..."
		chmod a+wx `cat .writeabledirs`

		echo "Removing unnecessary files..."
		find -name ".svn" -exec rm -rf {} \; 2> /dev/null
	;;

	clean)
		echo "Removing blank directories..."
		rm -rf `cat .blankdirs`
	;;

	*)
		echo "Usage: ./hypworks.sh <command>";
		echo "./hypworks.sh help for more details";
	;;

esac
