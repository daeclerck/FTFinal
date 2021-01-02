/* Set Foreign Key Check To 0 */
SET FOREIGN_KEY_CHECKS = 0;

/* Delete Existing Tables To Prevent Errors */
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS UnitsOfMeasurement;
DROP TABLE IF EXISTS Nutrients;
DROP TABLE IF EXISTS WorkoutTypes;
DROP TABLE IF EXISTS WorkoutRoutines;
DROP TABLE IF EXISTS WorkoutHistory;
DROP TABLE IF EXISTS UnitConversion;
DROP TABLE IF EXISTS Weight;
DROP TABLE IF EXISTS Meal;
DROP TABLE IF EXISTS Food;
DROP TABLE IF EXISTS FoodInMeal;
DROP TABLE IF EXISTS FoodNutrients;

/* Create Tables */
CREATE TABLE IF NOT EXISTS `User` (
  AccountID     CHAR(8)        NOT NULL,
  UserName      VARCHAR(20)    NOT NULL,
    PRIMARY KEY(AccountID)
);

CREATE TABLE IF NOT EXISTS UnitsOfMeasurement (
  UOMname       VARCHAR(20)    NOT NULL,
    PRIMARY KEY(UOMname)
);

CREATE TABLE IF NOT EXISTS Nutrients (
  NutrientName  VARCHAR(20)    NOT NULL,
  NutrientType  VARCHAR(20)    NOT NULL,
  DailyIntake   DECIMAL(11, 6) NOT NULL,
    PRIMARY KEY(NutrientName)
);

CREATE TABLE IF NOT EXISTS WorkoutTypes (
  WorkoutName   VARCHAR(20)    NOT NULL,
    PRIMARY KEY(WorkoutName)
);

CREATE TABLE IF NOT EXISTS WorkoutRoutines (
  RoutineID     CHAR(8)        NOT NULL,
  RoutineName   VARCHAR(20)    NOT NULL,
  FKWorkoutName VARCHAR(20)    NOT NULL,
    PRIMARY KEY(RoutineID),
    FOREIGN KEY(FKWorkoutName) REFERENCES WorkoutTypes(WorkoutName)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS WorkoutHistory (
  FKRoutineID   CHAR(8)        NOT NULL,
  FKAccountID   CHAR(8)        NOT NULL,
  StartTime     DATETIME       NOT NULL,
  EndTime       DATETIME       NOT NULL,
  Intensity     VARCHAR(20)    NOT NULL,
  Calories      INT(4)         NOT NULL,
    PRIMARY KEY(FKRoutineID, FKAccountID, StartTime),
    FOREIGN KEY(FKRoutineID) REFERENCES WorkoutRoutines(RoutineID),
    FOREIGN KEY(FKAccountID) REFERENCES `User`(AccountID)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS UnitConversion (
  FKUnitFrom    VARCHAR(20)     NOT NULL,
  FKUnitTo      VARCHAR(20)     NOT NULL,
  Conversion    DECIMAL(11, 6)  NOT NULL,
    PRIMARY KEY(FKUnitFrom, FKUnitTo),
    FOREIGN KEY(FKUnitFrom) REFERENCES UnitsOfMeasurement(UOMname),
    FOREIGN KEY(FKUnitTo) REFERENCES UnitsOfMeasurement(UOMname)
);

CREATE TABLE IF NOT EXISTS Weight (
  FKAccountID   CHAR(8)          NOT NULL,
  Recorded      DATETIME         NOT NULL,
  FKUOMname     VARCHAR(20)      NOT NULL,
  CurrentWeight DECIMAL(5, 2)    NOT NULL,
    PRIMARY KEY(Recorded, FKAccountID),
    FOREIGN KEY(FKAccountID) REFERENCES `User`(AccountID)
    ON DELETE CASCADE,
    FOREIGN KEY(FKUOMname) REFERENCES UnitsOfMeasurement(UOMname)
);

CREATE TABLE IF NOT EXISTS Meal (
  MealID        CHAR(8)          NOT NULL,
  FKAccountID   CHAR(8)          NOT NULL,
  TimeEaten     DATETIME         NOT NULL,
    PRIMARY KEY(MealID),
    FOREIGN KEY(FKAccountID) REFERENCES `User`(AccountID)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Food (
  FoodID        CHAR(8)          NOT NULL,
  FoodName      VARCHAR(20)      NOT NULL,
  FKUOMname     VARCHAR(20)      NOT NULL,
  ServingSize   DECIMAL(5, 2)    NOT NULL,
  CalPerServing DECIMAL(5, 2)    NOT NULL,
    PRIMARY KEY(FoodID),
    FOREIGN KEY(FKUOMname) REFERENCES UnitsOfMeasurement(UOMname)
);

CREATE TABLE IF NOT EXISTS FoodInMeal (
  FKMealID      CHAR(8)          NOT NULL,
  FKFoodID      CHAR(8)          NOT NULL,
  Servings      DECIMAL(5, 2)    NOT NULL,
  FKUOMname     VARCHAR(20)      NOT NULL,
    PRIMARY KEY(FKMealID, FKFoodID),
    FOREIGN KEY(FKMealID) REFERENCES Meal(MealID) 
    ON DELETE CASCADE,
    FOREIGN KEY(FKFoodID) REFERENCES Food(FoodID)
    ON DELETE CASCADE,
    FOREIGN KEY(FKUOMname) REFERENCES UnitsOfMeasurement(UOMname)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS FoodNutrients (
  FKNutrientName VARCHAR(20)    NOT NULL,
  FKFoodID       CHAR(8)        NOT NULL,
  FKUOMname      VARCHAR(20)    NOT NULL,
  PerServing     DECIMAL(12, 8) NOT NULL,
    PRIMARY KEY(FKNutrientName, FKFoodID),
    FOREIGN KEY(FKNutrientName) REFERENCES Nutrients(NutrientName),
    FOREIGN KEY(FKUOMname) REFERENCES UnitsOfMeasurement(UOMname),
    FOREIGN KEY(FKFoodID) REFERENCES Food(FoodID)
    ON DELETE CASCADE
);

/*  Return Foreign Key Check To 1 */
SET FOREIGN_KEY_CHECKS = 1; 
