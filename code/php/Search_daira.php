
    <?php
      include 'connect.php';
      $type = $_POST['typeofgeom'];
      $type=strtoupper($type);
      $result=$pdo->query("SELECT *, ST_AsGeoJson(ST_Transform(ST_SetSRID(geom, 32631),4326) )AS geojson FROM daira WHERE id_daira='$type';"); //4 chiffre apres la virgule
    
      $features=[];
     foreach($result as $row)
     {
       unset($row['geom']);
       unset($row['gid']);
       unset($row['id_daira']);
       unset($row['id_wil']);
       $geometry=$row['geojson']=json_decode($row['geojson']);
       unset($row['geojson']);
       $feature=["type"=>"Feature","properties"=>$row,"geometry"=>$geometry];
       array_push($features,$feature);
     }
    $featureCollection=["type"=>"FeatureCollection","features"=>$features];
    echo json_encode($featureCollection);
    
    
    ?>
