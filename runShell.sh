#!/bin/bash
# Git Hook Shell

eventType=$1;
projectPath=$2;

echo "---- Shell Run ----"

echo "Shell # cd ${projectPath}"
cd ${projectPath}

if [ $? == 1 ]
then
    exit 1;
fi

echo "Shell # git status"
/usr/bin/git status

if [ $? != 0 ]
then
    exit 128;
fi

echo "Shell # git ${eventType}"
/usr/bin/sudo /usr/bin/git ${eventType}

if [ $? == 1 ]
then
    exit 1;
fi

echo "done!"
