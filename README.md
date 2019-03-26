# Tschallacka's Formtools

These formtools can be useful for expanding your backend forms with the   
functionality they provide. Just drop this repository in your plugins directory   
or install it via the backend plugin manager in your OctoberCMS installation.  

If you wish to run the PhpUnit tests to verify if everything works after working  
on a pull request, make sure you run it on a version of October that has the  
./tests directory(a composer install or a git clone).  

To run the PHPUnit tests browse to this directory and execute
../../../vendor/bin/phpunit 

## Current features of this OctoberCMS plugin:

* Colorpicker    
  A simple color picker that allows the selection of an RGBA color and that is  
  stored in text format: rgba(164, 194, 244, 0.43)  
  **usage**  
  `type: tsch_color_picker`
  
* Filtered Checkbox List
  Just like the original checkboxlist and the code is also based Octobers checkboxlist element.
  It only adds a search functionality through the options and a way to hide unselected items or selected items.
  **usage**
  `type: tsch_filtered_checkboxlist`
  
