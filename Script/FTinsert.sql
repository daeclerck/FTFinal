--Static Values

--Units Of Measurement
INSERT INTO UnitsOfMeasurement(UOMname) VALUES("Grams");
INSERT INTO UnitsOfMeasurement(UOMname) VALUES("Ounces");
INSERT INTO UnitsOfMeasurement(UOMname) VALUES("Tablespoons");
INSERT INTO UnitsOfMeasurement(UOMname) VALUES("Cups");
INSERT INTO UnitsOfMeasurement(UOMname) VALUES("Pounds");
INSERT INTO UnitsOfMeasurement(UOMname) VALUES("Kilograms");
INSERT INTO UnitsOfMeasurement(UOMname) VALUES("Teaspoons");

--Nutrients
--NOTE: Recommended daily intake values are in grams
INSERT INTO Nutrients(NutrientName, NutrientType, DailyIntake) VALUES ("Protein", "Macronutrient", "56");
INSERT INTO Nutrients(NutrientName, NutrientType, DailyIntake) VALUES ("Fat", "Macronutrient", "77");
INSERT INTO Nutrients(NutrientName, NutrientType, DailyIntake) VALUES ("Carbohydrates", "Macronutrient", "325");
INSERT INTO Nutrients(NutrientName, NutrientType, DailyIntake) VALUES ("Vitamin A", "Micronutrient", "0.0009");
INSERT INTO Nutrients(NutrientName, NutrientType, DailyIntake) VALUES ("Vitamin D", "Micronutrient", "0.02");
INSERT INTO Nutrients(NutrientName, NutrientType, DailyIntake) VALUES ("Vitamin C", "Micronutrient", "0.09");
INSERT INTO Nutrients(NutrientName, NutrientType, DailyIntake) VALUES ("Caffeine", "Micronutrient", "0.4");

--Workout Types
INSERT INTO WorkoutTypes(WorkoutName) VALUES("Strength");
INSERT INTO WorkoutTypes(WorkoutName) VALUES("Endurance");
INSERT INTO WorkoutTypes(WorkoutName) VALUES("Flexibility");

--Unit Conversion
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Grams", "Kilograms", "0.001");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Grams", "Pounds", "0.002205");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Grams", "Ounces", "0.035274");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Grams", "Cups", "0.004409");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Grams", "Tablespoons", "0.070671");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Grams", "Teaspoons", "0.209790");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Grams", "Grams", "1");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Kilograms", "Grams", "1000");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Kilograms", "Pounds", "2.20462");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Kilograms", "Ounces", "35.274");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Kilograms", "Cups", "4.40917");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Kilograms", "Tablespoons", "70.6714");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Kilograms", "Teaspoons", "209.79");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Kilograms", "Kilograms", "1");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Pounds", "Grams", "453.6");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Pounds", "Kilograms", "0.4536");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Pounds", "Ounces", "16");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Pounds", "Cups", "2");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Pounds", "Tablespoons", "32");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Pounds", "Teaspoons", "96");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Pounds", "Pounds", "1");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Ounces", "Grams", "28.34949");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Ounces", "Kilograms", "0.028349");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Ounces", "Pounds", "0.0625");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Ounces", "Cups", "0.125");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Ounces", "Tablespoons", "2");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Ounces", "Teaspoons", "6");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Ounces", "Ounces", "1");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Cups", "Grams", "226.8");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Cups", "Kilograms", "0.2268");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Cups", "Pounds", "0.5");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Cups", "Ounces", "8");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Cups", "Tablespoons", "16");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Cups", "Teaspoons", "48");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Cups", "Cups", "1");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Tablespoons", "Grams", "14.15");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Tablespoons", "Kilograms", "0.01415");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Tablespoons", "Pounds", "0.031");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Tablespoons", "Ounces", "0.5");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Tablespoons", "Cups", "0.063");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Tablespoons", "Teaspoons", "3");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Tablespoons", "Tablespoons", "1");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Teaspoons", "Grams", "4.767");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Teaspoons", "Kilograms", "0.004767");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Teaspoons", "Pounds", "0.01");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Teaspoons", "Ounces", "0.167");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Teaspoons", "Cups", "0.21");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Teaspoons", "Tablespoons", "0.333");
INSERT INTO UnitConversion(FKUnitFrom, FKUnitTo, Conversion) VALUES("Teaspoons", "Teaspoons", "1");


--Dynamic Values

--User
INSERT INTO User(AccountID, UserName) VALUES("12345678", "John");
INSERT INTO User(AccountID, UserName) VALUES("87654321", "Troy");

--Workout Routines
INSERT INTO WorkoutRoutines(RoutineID, RoutineName, FKWorkoutName) VALUES("Workout1", "Planks", "Strength");
INSERT INTO WorkoutRoutines(RoutineID, RoutineName, FKWorkoutName) VALUES("Workout2", "Walking", "Endurance");
INSERT INTO WorkoutRoutines(RoutineID, RoutineName, FKWorkoutName) VALUES("Workout3", "Shoulder Stretch", "Endurance");

--Workout History
INSERT INTO WorkoutHistory(FKRoutineID, FKAccountID, StartTime, EndTime, Intensity, Calories) VALUES("Workout1", "12345678", "2019-12-02 12:00:00", "2019-12-02 13:00:00", "Mediocre", "221");
INSERT INTO WorkoutHistory(FKRoutineID, FKAccountID, StartTime, EndTime, Intensity, Calories) VALUES("Workout2", "12345678", "2019-12-02 13:01:00", "2019-12-02 14:00:00", "Mediocre", "356");
INSERT INTO WorkoutHistory(FKRoutineID, FKAccountID, StartTime, EndTime, Intensity, Calories) VALUES("Workout3", "12345678", "2019-12-02 14:01:00", "2019-12-02 15:00:00", "Mediocre", "124");
INSERT INTO WorkoutHistory(FKRoutineID, FKAccountID, StartTime, EndTime, Intensity, Calories) VALUES("Workout3", "87654321", "2020-12-05 16:01:00", "2020-12-05 17:00:00", "Mediocre", "500");

--Weight
INSERT INTO Weight(FKAccountID, Recorded, FKUOMname, CurrentWeight) VALUES("12345678", "2019-11-28 13:00:00", "Pounds", "150");
INSERT INTO Weight(FKAccountID, Recorded, FKUOMname, CurrentWeight) VALUES("12345678", "2019-12-02 13:00:00", "Pounds", "98");
INSERT INTO Weight(FKAccountID, Recorded, FKUOMname, CurrentWeight) VALUES("12345678", "2019-12-24 13:00:00", "Pounds", "123");
INSERT INTO Weight(FKAccountID, Recorded, FKUOMname, CurrentWeight) VALUES("87654321", "2020-12-24 13:00:00", "Pounds", "220");

--Meal
INSERT INTO Meal(MealID, FKAccountID, TimeEaten) VALUES("Meal0001", "12345678", "2020-06-10 8:00:00");
INSERT INTO Meal(MealID, FKAccountID, TimeEaten) VALUES("Meal0002", "12345678", "2020-06-15 9:00:00");
INSERT INTO Meal(MealID, FKAccountID, TimeEaten) VALUES("Meal0003", "87654321", "2020-12-30 9:00:00");

--Food
INSERT INTO Food(FoodID, FoodName, FKUOMname, ServingSize, CalPerServing) VALUES("587e7373", "Lasagna", "Cups", "2.00", "500.00");
INSERT INTO Food(FoodID, FoodName, FKUOMname, ServingSize, CalPerServing) VALUES("5ec249ae", "Watermelons", "Cups", "0.66", "30.00");
INSERT INTO Food(FoodID, FoodName, FKUOMname, ServingSize, CalPerServing) VALUES("chicken1", "Chicken", "Pounds", "1", "100.00");

--Food In Meal
INSERT INTO FoodInMeal(FKMealID, FKFoodID, Servings, FKUOMname) VALUES("Meal0001", "587e7373", "3", "Pounds");
INSERT INTO FoodInMeal(FKMealID, FKFoodID, Servings, FKUOMname) VALUES("Meal0002", "5ec249ae", "1", "Pounds");
INSERT INTO FoodInMeal(FKMealID, FKFoodID, Servings, FKUOMname) VALUES("Meal0003", "chicken1", "5", "Pounds");

--Food Nutrients
INSERT INTO FoodNutrients(FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES("Carbohydrates", "587e7373", "Grams", "27");
INSERT INTO FoodNutrients(FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES("Protein", "587e7373", "Grams", "1.3");
INSERT INTO FoodNutrients(FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES("Fat", "587e7373", "Grams", "0.4");
INSERT INTO FoodNutrients(FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES("Carbohydrates", "5ec249ae", "Grams", "23");
INSERT INTO FoodNutrients(FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES("Protein", "5ec249ae", "Grams", "79");
INSERT INTO FoodNutrients(FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES("Fat", "5ec249ae", "Grams", "41");
INSERT INTO FoodNutrients(FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES("Carbohydrates", "chicken1", "Grams", "15");
INSERT INTO FoodNutrients(FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES("Protein", "chicken1", "Grams", "3.6");
INSERT INTO FoodNutrients(FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES("Fat", "chicken1", "Grams", "30");