## Lumeon Technical Test


### Overview

Thank you for your interest, the aim of this technical task is to gauge your understanding and approach to writing code. The test aims to mimic the the kind of code that you may comes across at Lumeon, which is a combination of modern Symfony code along with legacy code. Please do note that this is not an exact copy of the Lumeon environment.

We are looking for:

- Clean concise code
- Unit tests
- Testable programming techniques
- Understanding of existing code

### Test Instructions

The aim of the test is not to get you to concrete out existing repository classes to a specific DB/ORM, so please do not feel the need to add in SQL queries or other DB calls. Wireframe calls are acceptable for these purposes as long as it is made clear what the expected return is e.g.:
```
/** @return Entity */
public function selectById(){}
```

#### Question
Please answer the following question textually.

The file web/showhospitalpatients.php is intended to retrieve a list of patients for a given hospital and return that in json format. Are there any comments you would like to make? What could be improved about the code ?

* This is only a simple example but in a more robust system there should be an authentication and authorisation check
* There is no sanitation of input, assuming the id is a known format only this format should be allowed any unauthorised characters should be stripped
* There is no validation with the exception that an ID exist, if the ID is a known format (i.e. integer) then this should be validated before a call to the database and return error with HTML status code 400
* The error JSON response should be using HTML status code 400 for missing ID
* There should be a check for valid hospital ID, if ID is not found a 404 should be returned before any further queries to the DB (i.e. to get patients)
* The hospital repository should not need a specific method for retrieving via ID, if an ORM such as Doctrine is in use there should be a basic ->find() method for this already
* Hospital and Patient entities should be related so there should be no need to get the patient repository separately and call to a method, an ORM would allow $hospital->getPatients()
* All data relating to these entities is being returned, this could be reduced via other arguments to only the data required
* JsonResponse assumes simple entities, if doctrine is in use then a proxy entity could be returned if found through an association  
* Using a Symfony controller would make this code much more maintainable and would allow the use of sanitation/validation as part of the routing and the param converter could be used to load the hospital, reducing the code in the action to just the return Json statement. 
* In addition a full Symfony implementation would allow the use of forms for validation and the Authentication provider

#### Exercise

This is the coding portion of the test. Please write code as well as you can using existing entities/repositories where appropriate and adding classes/files where needed.

Please add a new endpoint which allows us to save a patient against a doctor, bearing in mind that a doctor can have multiple patients.
- The output should be JSON.
- We should receive the doctor and the patients associated with that doctor in the output.
- Return any messages in the 'msg' key as per the existing code. 

We are looking for:

- Best practice in coding
- Unit test(s)
- The code to be hosted via git (e.g. github.com has free accounts)

### Your code should target

- PHP 5.6
- Symfony 2.8

### Final Words
Thank you very much for considering Lumeon, we aim to look at all entries as soon as possible but due to business needs we would like to apologise for any delay in advance. Good luck!

### Running the application
I wasn't sure if you wanted an endpoint to save a patient against a doctor or an endpoint to create a new patient and assign them to a doctor so i have created both.

I've assumed that you have created a database called symfony that the root user has access to and you have run "app/console doctrine:schema:create --force" then added some dummy data.

To assign an existing patient you need to know the patient and doctor ID, then go to /doctor/{doctorId}/{patientId};

To assign a new patient do a post to /doctor/{id} with post values for name, dob and gender