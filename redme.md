<!-- SELECT games.*, platforms.name AS platform,
         categorie.name AS categorie, publishers.name AS publisher 
         FROM games LEFT JOIN platforms ON games.platform_id = platforms.id
          LEFT JOIN categorie ON games.categorie_id = categorie.id LEFT JOIN
           publishers ON games.publisher_id = publishers.id ORDER BY games.id DESC') -->