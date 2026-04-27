<?php

require_once 'config.php';
function selectAnimals($pdo)
{
    $sql = "SELECT * FROM animals";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function detailsAnimal($pdo, $id)
{
    $sql = "SELECT * FROM animal_details WHERE animal_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function selectVolunteers($pdo)
{
    $sql = "SELECT * FROM volunteers";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function addVolunteer($pdo, $name, $phone, $skill, $photo_url)
{
    $sql = "INSERT INTO volunteers (full_name, phone, skill, photo_url) VALUES (:full_name, :phone, :skill, :photo_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':full_name' => $name,
        ':phone' => $phone,
        ':skill' => $skill,
        ':photo_url' => $photo_url
    ]);
}

function checkVolunteerByPhone($pdo, $phone)
{
    $sql = "SELECT * FROM volunteers WHERE phone = :phone";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':phone' => $phone]);
    return $stmt->fetch();
}

function addAdoption($pdo)
{
    $sql = "INSERT INTO adoptions (animal_id, adopter_name, adopter_phone, adoption_date) VALUES (:animal_id, :adopter_name, :adopter_phone, CURDATE())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($_POST);
}

function checkAdoption($pdo, $animal_id)
{
    $sql = "SELECT * FROM adoptions WHERE animal_id = :animal_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':animal_id' => $animal_id]);
    return $stmt->fetch();
}

function addAnimal($pdo, $name, $species, $breed, $age, $status, $photo_url)
{
    $sql = "INSERT INTO animals (name, species, breed, age, status, photo_url) VALUES (:name, :species, :breed, :age, :status, :photo_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':species' => $species,
        ':breed' => $breed,
        ':age' => $age,
        ':status' => $status,
        ':photo_url' => $photo_url
    ]);
    return $pdo->lastInsertId();
}

function deleteAnimal($pdo, $id)
{
    $sql = "DELETE FROM animals WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}

function deleteVolunteer($pdo, $id)
{
    $sql = "DELETE FROM volunteers WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}

function getAnimalById($pdo, $id)
{
    $sql = "SELECT * FROM animals WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function updateAnimal($pdo, $id, $name, $species, $breed, $age, $status, $photo_url, $character_desc, $health_desc)
{
    $sql = "UPDATE animals SET name='$name', species='$species', breed='$breed', age='$age', status='$status', photo_url='$photo_url' WHERE id='$id'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $sql2 = "UPDATE animal_details SET character_desc='$character_desc', health_desc='$health_desc' WHERE animal_id='$id'";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
}

function updateVolunteer($pdo, $id, $full_name, $phone, $skill, $photo_url)
{
    $sql = "UPDATE volunteers SET full_name = :full_name, phone = :phone, skill = :skill, photo_url = :photo_url WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':full_name' => $full_name,
        ':phone' => $phone,
        ':skill' => $skill,
        ':photo_url' => $photo_url,
        ':id' => $id
    ]);
}

function getVolunteerById($pdo, $id)
{
    $sql = "SELECT * FROM volunteers WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function getTreatment($pdo, $animal_id)
{
    $sql = "SELECT treatment_text FROM animal_details WHERE animal_id = :animal_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':animal_id' => $animal_id]);
    return $stmt->fetch();
}

function updateTreatment($pdo, $animal_id, $treatment_text)
{
    $stmt = $pdo->prepare("SELECT * FROM animal_details WHERE animal_id = :animal_id");
    $stmt->execute([':animal_id' => $animal_id]);
    $exists = $stmt->fetch();

    if ($exists) {
        $sql = "UPDATE animal_details SET treatment_text = :treatment_text WHERE animal_id = :animal_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':treatment_text' => $treatment_text, ':animal_id' => $animal_id]);
    } else {
        $sql = "INSERT INTO animal_details (animal_id, treatment_text) VALUES (:animal_id, :treatment_text)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':animal_id' => $animal_id, ':treatment_text' => $treatment_text]);
    }
}
?>