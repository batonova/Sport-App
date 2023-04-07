--Создание отношений

CREATE TABLE users(
    UserID NUMERIC(4) PRIMARY KEY,
    User_Name VARCHAR(70) NOT NULL,
    Email VARCHAR(40) NOT NULL UNIQUE,
    Gender VARCHAR(1) CHECK (Gender IN ('м', 'ж')),
    Height NUMERIC(3,2) CHECK (Height > 0 AND Height < 2.3),
    Weight NUMERIC(3) CHECK (Weight > 0 AND Weight < 230),
    Birth_Date DATE,
    Health_Group NUMERIC(1) CHECK (Health_Group < 5 AND Health_Group > 0),
    Train_Level VARCHAR(20) CHECK (Train_Level IN ('Начинающий', 'Продолжающий', 'Профессионал')),
    Score NUMERIC(7) DEFAULT 0
);

CREATE TABLE inventories(
    Inventory VARCHAR(100) PRIMARY KEY
);

CREATE TABLE users_inventories(
    UserID NUMERIC(4)
    REFERENCES users(UserID) ON DELETE CASCADE,
    Inventory VARCHAR(100)
    REFERENCES inventories(Inventory) ON DELETE CASCADE,
    CONSTRAINT users_inventories_key PRIMARY KEY(UserID, Inventory)
);

CREATE TABLE contraindications(
    Contraindication VARCHAR(100) PRIMARY KEY
);

CREATE TABLE users_contraindications(
    UserID NUMERIC(4)
    REFERENCES users(UserID) ON DELETE CASCADE,
    Contraindication VARCHAR(100)
    REFERENCES contraindications(Contraindication) ON DELETE CASCADE,
    CONSTRAINT users_contraindications_key PRIMARY KEY(UserID, Contraindication)
);

CREATE TABLE exercises(
    ExerciseID NUMERIC(4) PRIMARY KEY,
    Ex_Name VARCHAR(60) NOT NULL,
    GIF VARCHAR(100) NOT NULL,
    Text_Description VARCHAR(500),
    Train_Level VARCHAR(20) CHECK (Train_Level IN ('Начинающий', 'Продолжающий', 'Профессионал')),
    Health_Group NUMERIC(2) NOT NULL 
    CHECK (Health_Group < 5 AND Health_Group > 0),
    Points NUMERIC(3) NOT NULL CHECK (Points > 0 and Points <= 100)
    
);

CREATE TABLE exercises_inventories(
    ExerciseID NUMERIC(4)
    REFERENCES exercises(ExerciseID) ON DELETE CASCADE,
    Inventory VARCHAR(100)
    REFERENCES inventories(Inventory) ON DELETE CASCADE,
    CONSTRAINT exercises_inventories_key PRIMARY KEY(ExerciseID, Inventory)
);

CREATE TABLE exercises_contraindications(
    ExerciseID NUMERIC(4)
    REFERENCES exercises(ExerciseID) ON DELETE CASCADE,
    Contraindication VARCHAR(100)
    REFERENCES contraindications(Contraindication) ON DELETE CASCADE,
    CONSTRAINT exercises_contraindications_key PRIMARY KEY(ExerciseID, Contraindication)
);

CREATE TABLE workouts(
    UserID NUMERIC(4)
    REFERENCES users(UserID) ON DELETE CASCADE,
    ExerciseID NUMERIC(4)
    REFERENCES exercises(ExerciseID) ON DELETE SET NULL,
    Done CHAR(3) NOT NULL CHECK (Done in ('Да', 'Нет')),
    Exe_Order NUMERIC(1) NOT NULL CHECK (Exe_Order > 0 and Exe_Order < 9),
    Exercise_Time TIMESTAMP,
    CONSTRAINT workout_key PRIMARY KEY(UserID, ExerciseID, Exercise_Time)
); 

CREATE TABLE pulses(
    UserID NUMERIC(10)
    REFERENCES users(UserID) ON DELETE CASCADE,
    Pulse_Time TIMESTAMP,
    Pulse_Before NUMERIC(3) CHECK (Pulse_Before > 0 AND Pulse_Before < 300),
    Pulse_After NUMERIC(3) CHECK (Pulse_After > 0 AND Pulse_After < 300),
    CONSTRAINT pulses_key PRIMARY KEY(UserID, Pulse_Time)
); 

CREATE TABLE trainings(
    UserID NUMERIC(4)
    REFERENCES users(UserID) ON DELETE CASCADE,
    Points NUMERIC(3) NOT NULL CHECK (Points > 0 and Points <= 100),
    Training_Time TIMESTAMP,
    CONSTRAINT trainings_key PRIMARY KEY(UserID, Training_Time)
);

CREATE TABLE awards(
    AwardsID NUMERIC(5) PRIMARY KEY,
    Awards_Name VARCHAR(40) NOT NULL,
    GIF VARCHAR(100),
    Description VARCHAR(300),
    Price_Award NUMERIC(4),
    Start_Action TIMESTAMP,
    End_Action TIMESTAMP
);

CREATE TABLE users_awards(
    UserID NUMERIC(4)
    REFERENCES users(UserID) ON DELETE CASCADE,
    AwardsID NUMERIC(5)
    REFERENCES awards(AwardsID) ON DELETE CASCADE,
    Used VARCHAR(3) CHECK (Used IN ('Да', 'Нет'))
);

-- Триггеры

-- Меняет набор инвентаря пользователя

CREATE FUNCTION insert_users_inventories() 
RETURNS trigger AS 
$body$
	BEGIN
		IF (NEW.Inventory NOT IN
				(SELECT DISTINCT * FROM Inventories)
		    OR NEW.UserID NOT IN 
		   		(SELECT UserID FROM users))
	    THEN
		BEGIN
			RETURN NULL;
		END;
		END IF;
		IF (EXISTS(SELECT * FROM users_inventories AS u
				  WHERE u.UserID = NEW.UserID 
				  AND u.Inventory = NEW.Inventory)) 
		THEN 
		BEGIN
			DELETE FROM users_inventories  AS u
			WHERE u.UserID = NEW.UserID 
				 AND u.Inventory = NEW.Inventory;
		END;
		END IF;
		RETURN NEW;
	END;
$body$
LANGUAGE plpgsql;

CREATE TRIGGER insert_into_users_inventories
BEFORE INSERT ON users_inventories
FOR EACH ROW
EXECUTE FUNCTION insert_users_inventories();

CREATE FUNCTION delete_users_inventories() 
RETURNS trigger AS 
$body$
	BEGIN
		DELETE FROM users_inventories AS u
		WHERE u.UserID IN (SELECT UserID FROM new_table) 
			  AND u.Inventory NOT IN (SELECT Inventory FROM new_table);
		RETURN NEW;
	END;
$body$
LANGUAGE plpgsql;

CREATE TRIGGER delete_from_users_inventories
AFTER INSERT ON users_inventories
REFERENCING NEW TABLE AS new_table
FOR EACH ROW
EXECUTE FUNCTION delete_users_inventories();

-- Меняет набор противопоказаний пользователя

CREATE FUNCTION insert_users_contraindications() 
RETURNS trigger AS 
$body$
	BEGIN
		IF (NEW.Contraindication NOT IN
				(SELECT DISTINCT * FROM contraindications)
		    OR NEW.UserID NOT IN 
		   		(SELECT UserID FROM users))
	    THEN
		BEGIN
			RETURN NULL;
		END;
		END IF;
		IF (EXISTS(SELECT * FROM users_contraindications AS u
				  WHERE u.UserID = NEW.UserID 
				  AND u.Contraindication = NEW.Contraindication)) 
		THEN 
		BEGIN
			DELETE FROM users_contraindications  AS u
			WHERE u.UserID = NEW.UserID 
				 AND u.Contraindication = NEW.Contraindication;
		END;
		END IF;
		RETURN NEW;
	END;
$body$
LANGUAGE plpgsql;

CREATE TRIGGER insert_into_users_contraindications
BEFORE INSERT ON users_contraindications
FOR EACH ROW
EXECUTE FUNCTION insert_users_contraindications();

CREATE FUNCTION delete_users_contraindications() 
RETURNS trigger AS 
$body$
	BEGIN
		DELETE FROM users_contraindications AS u
		WHERE u.UserID IN (SELECT UserID FROM new_table) 
			  AND u.Contraindication NOT IN (SELECT Contraindication FROM new_table);
		RETURN NEW;
	END;
$body$
LANGUAGE plpgsql;

CREATE TRIGGER delete_from_users_contraindications
AFTER INSERT ON users_contraindications
REFERENCING NEW TABLE AS new_table
FOR EACH ROW
EXECUTE FUNCTION delete_users_contraindications();

--Присваивает ID пользователю

CREATE FUNCTION insert_user() 
RETURNS trigger AS 
$body$
	DECLARE
		j integer := 0;
		i integer := 1;
		n integer := 0;
		a integer ARRAY;
	BEGIN
		n := (SELECT COUNT(*) FROM users);
		IF (n = 0)
	    THEN
		BEGIN
		    NEW.UserID = 1;
			RETURN NEW;
		END;
		END IF;
		IF (n = (SELECT MAX(UserID) FROM users)) 
		THEN 
		BEGIN
			NEW.UserID = (SELECT MAX(UserID) FROM users) + 1;
			RETURN NEW;
		END;
		END IF;
		a := ARRAY(SELECT UserID FROM users ORDER BY UserID);
		FOREACH j IN ARRAY a LOOP
			EXIT WHEN i > n;
			IF (i <> j) THEN
			BEGIN
				NEW.UserID = i;
				RETURN NEW;
			END;
			END IF;
			i := i + 1;
		END LOOP;
		NEW.UserID = i + 1;
		RETURN NEW;
	END;
$body$
LANGUAGE plpgsql;

CREATE TRIGGER insert_new_user
BEFORE INSERT ON users
FOR EACH ROW
EXECUTE FUNCTION insert_user();

--Присваивает ID упражнению

CREATE FUNCTION insert_exercise() 
RETURNS trigger AS 
$body$
	DECLARE
		j integer := 0;
		i integer := 1;
		n integer := 0;
		a integer ARRAY;
	BEGIN
		n := (SELECT COUNT(*) FROM exercises);
		IF (n = 0)
	    THEN
		BEGIN
		    NEW.ExerciseID = 1;
			RETURN NEW;
		END;
		END IF;
		IF (n = (SELECT MAX(ExerciseID) FROM exercises)) 
		THEN 
		BEGIN
			NEW.ExerciseID = (SELECT MAX(ExerciseID) FROM exercises) + 1;
			RETURN NEW;
		END;
		END IF;
		a := ARRAY(SELECT ExerciseID FROM exercises ORDER BY ExerciseID);
		FOREACH j IN ARRAY a LOOP
			EXIT WHEN i > n;
			IF (i <> j) THEN
			BEGIN
				NEW.ExerciseID = i;
				RETURN NEW;
			END;
			END IF;
			i := i + 1;
		END LOOP;
		NEW.ExerciseID = i + 1;
		RETURN NEW;
	END;
$body$
LANGUAGE plpgsql;

CREATE TRIGGER insert_new_exercise
BEFORE INSERT ON exercises
FOR EACH ROW
EXECUTE FUNCTION insert_exercise();

-- Устанавливает нужную дату-время при добавлении выполняемого упражнения

CREATE FUNCTION insert_workouts() 
RETURNS trigger AS 
$body$
	BEGIN
		NEW.Done = 'Нет';
		IF (NEW.Exe_Order = 1)
	    THEN
		BEGIN
		    NEW.Exercise_Time = CURRENT_TIMESTAMP;
			RETURN NEW;
		END;
		END IF;
		NEW.Exercise_Time = (SELECT MAX(Exercise_Time) 
							 FROM workouts 
							 WHERE UserID = NEW.UserID);
		RETURN NEW;
	END;
$body$
LANGUAGE plpgsql;

CREATE TRIGGER insert_new_workouts
BEFORE INSERT ON workouts
FOR EACH ROW
EXECUTE FUNCTION insert_workouts();

-- Устанавливает нужную дату-время при добавлении пульса

CREATE FUNCTION insert_pulses() 
RETURNS trigger AS 
$body$
	BEGIN
		NEW.Pulse_Time = CURRENT_TIMESTAMP;
		RETURN NEW;
	END;
$body$
LANGUAGE plpgsql;

CREATE TRIGGER insert_new_pulses
BEFORE INSERT ON pulses
FOR EACH ROW
EXECUTE FUNCTION insert_pulses();
