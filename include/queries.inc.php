<?php
$qItemCat = "SELECT
c.`Index`,
CASE WHEN ISNULL(s.`STRING`) THEN c.`Name` ELSE s.`STRING` END AS `Name`
FROM
`itemcategory` c
LEFT OUTER JOIN `stringdata` s
ON c.`String_Category_Name` = s.`CDSTR`;";

$qItemDataCount = "SELECT COUNT(*) AS `total` FROM `iteminfo` i
LEFT OUTER JOIN `stringdata` s1
ON i.`String_Item_Name` = s1.`CDSTR`
LEFT OUTER JOIN `stringdata` s2
ON i.`String_Item_Description` = s2.`CDSTR`
LEFT OUTER JOIN `itemcategory` c
ON i.`High_Category` = c.`High_Category`
AND i.`Medium_Category` = c.`Medium_Category`
AND i.`Low_Category` = c.`Low_Category`
LEFT OUTER JOIN `stringdata` s3
ON c.`String_Category_Name` = s3.`CDSTR`";

$qItemData = "SELECT
i.`ID`,
CASE WHEN ISNULL(s1.`STRING`) THEN i.`Name` ELSE s1.`STRING` END AS `Name`,
CASE WHEN ISNULL(s2.`STRING`) THEN '' ELSE s2.`STRING` END AS `Description`,
CASE WHEN ISNULL(s3.`STRING`) THEN c.`Name` ELSE s3.`STRING` END AS `Category`,
i.`NationEnable`,
i.`Item_Type`,
i.`Item_Type_Option`,
i.`Item_Category`,
i.`Grade`,
i.`Grinding_Trait_Able`,
i.`Abili_val`,
i.`Price_Buy`,
i.`Price_Sell`,
i.`Stack_Max`,
i.`Item_Lv`,
i.`Require_Level`,
i.`ItemValueLv`,
i.`Min_MasteryGrade`,
i.`Min_MasteryLevel`,
i.`Require_Sex`,
i.`Require_Job`,
i.`Equip_Type`,
i.`Equip_Slot`,
i.`Equip_Slot_Overlap`,
i.`Weapon_Type`,
i.`Armor_Type`,
i.`Bag_Size`,
i.`Bind_Type`,
i.`Durability`,
i.`Possession_Max`,
i.`RandomSet_ID`,
i.`Socket_GroupID`,
i.`Effect_ID_1`,
i.`Skill_ID_1`,
i.`Theme_ID`,
i.`Is_Drop`,
i.`Is_Deposit`,
i.`Is_Destruct`,
i.`Is_Sell`,
i.`Is_Trade`,
i.`Is_Compose`,
i.`High_Category`,
i.`Medium_Category`,
i.`Low_Category`,
i.`Ignore_Search`,
i.`Including_Button`,
i.`Costume_Animation`,
i.`FxGroupID`,
i.`Default_Color`,
i.`Color_Variation`,
i.`CollisionType_ID`,
i.`Icon`,
i.`UpdateCode`
FROM `iteminfo` i
LEFT OUTER JOIN `stringdata` s1
ON i.`String_Item_Name` = s1.`CDSTR`
LEFT OUTER JOIN `stringdata` s2
ON i.`String_Item_Description` = s2.`CDSTR`
LEFT OUTER JOIN `itemcategory` c
ON i.`High_Category` = c.`High_Category`
AND i.`Medium_Category` = c.`Medium_Category`
AND i.`Low_Category` = c.`Low_Category`
LEFT OUTER JOIN `stringdata` s3
ON c.`String_Category_Name` = s3.`CDSTR`";
?>