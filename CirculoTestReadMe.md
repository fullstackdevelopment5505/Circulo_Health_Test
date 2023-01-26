# Project's Title

Circulo Take Home Test

## Project Description

At Circulo Health, you need to make a list of **X** pharmacies for a specific patient based on their previously visited pharmacies, the distance away (miles) copay amount (dollars), and whether or not they support prior authorization (true/false). The method of compiling the list is as follows:

1. Every patient has a list of pharmacies **B**, that they have visited in the past. Take names of the sorted and filtered pharmacies that support prior authorization from the list first. (Technical details below)
2. There is a list of the nearest pharmacies C. If the patient's list does not have enough pharmacies, then the rest of the result list should be filled up with names from the sorted and filtered pharmacies from this list. (Technical details below)
3. If after 1 and 2 the patient's list does not have enough pharmacies, the result list should be filled up, if there are any, with the rest of the pharmacies from list B (that as an effect, are in alphabetical order and do not support prior authorization)
4. If the patient's list and the list of the closet pharmacies combined do not provide enough names, you should return an array only consisting of the string: "Not enough data"

## Input File Format
<number>
<name>:<supports_prior_auth>
<name>:<distance>:<copay>:<supports_prior_auth>
### sample
10                       : the number to display
CVS Pharmacy:True        : visited pharmacy
Walmart:false		 : visited pharmacy
Walgreens:5.2:2:true     : nearest pharmacy
Kroger Company:3.5:1:true: nearest pharmacy

## Output File Format
<number>
<name>
<name>
### sample
10
CVS Pharmacy
Walmart
Walgreens
## Software Design
The project consists of 3 classes and 6 functions. The Class of Pharmacy is a function that abstracts the pharmacy object, and this class consists of two properties and one function. The two properties are the pharmacy name and the pharmacy's authentication status, and it is a function that shows the pharmacy's authentication result. The class of the visited pharmacy and the class of nearby pharmacies are inherited class of the class of pharmacy. These two inherited classes have a Compare function of each. The Compare function compares the states between the two pharmacies and returns the result as a true/False value. If True, the condition is good, if false, the condition of the pharmacy is bad. The class of the nearest pharmacy has two member variables. The member variables are distance and price. There are 6 global functions. It consists of an InputSolution function, a GetResultSolution function, an OutputSolution, a Validate function, a SortMakeArray function, and a IsBool function. Here, the InputSolution function sorts the visitor class list and the nearby pharmacy class list from the input file according to the pharmacy status. The GetResultSolution function builds the list of resulting pharmacies in four steps. Step 4 is reflected in the requirements. The Validate function determines whether the data of each pharmacy coming from the input file is valid. The SortMakeArray function sorts the list of visited hospitals and the list of nearby hospitals according to the status of the hospitals. The OutputSolution performs the function of outputting the result list.

## How to install and Run the Project

Use the package manager []
(https:// ) to install.

```bash
cd deploy
php health.php
Command: input.txt
```

## How to Test the Project
```bash
cd test
phpunit PharmacyTest.php
phpunit VisitedPharmacyTest.php
phpunit NearestPharmacyTest.php
phpunit FunctionsTest.php

```

## Add a License

[MIT]