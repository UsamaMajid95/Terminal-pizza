<?php
namespace app;
use app\pizzes;

class sum extends pizzes{
    
    public function check($typeofpizze,$size,$coyc){
        $pizza_cost = [
            "Пепперони"=>['21cm' => 3,'26cm' => 4,'31cm'=> 5,'45cm'=> 6],
            "Деревенская"=>['21cm' => 5,'26cm' => 6,'31cm'=> 7,'45cm'=> 8],
            "Гавайская"=>['21cm' => 5,'26cm' => 6,'31cm'=> 7,'45cm'=> 8],
            "Грибная"=>['21cm' => 5.5,'26cm' => 6.5,'31cm'=> 7.5,'45cm'=> 8.5]
        ];
        #----Prices of pizza-----
        
        $sauces = [
            'сырный'=> 1,
            'кисло-сладкий' =>1,
            'чесночный' => 0.5,
            'барбекю' => 2
        ];
        #----Prices of sauce-----

        $sql1 = "INSERT INTO `pizza` VALUES ('','$typeofpizze')";
        mysqli_query($this->conn, $sql1);
        #----Insert order pizza into database----
        
        $pizza_id = mysqli_insert_id($this->conn);
        #----Get id of order pizza
        
        $size_price=0;
        foreach($size as $size_item){
            $size_cost_for_one_pizza = $pizza_cost[$typeofpizze][$size_item];
            $size_price = $size_price + $size_cost_for_one_pizza;
            $sql2 = "INSERT INTO `size` VALUES ('','$size_item','{$pizza_cost[$typeofpizze][$size_item]}','$pizza_id')";
            mysqli_query($this->conn, $sql2);
        }
         

        $sauces_cost=0;
        foreach ($coyc as $item){
            $item_price = $sauces[$item];
            $sauces_cost = $sauces_cost + $item_price;
            $sql3 = "INSERT INTO `sauce` VALUES ('','$item','$sauces[$item]','$pizza_id')";
            mysqli_query($this->conn, $sql3);
        }
        $total_price_USD = $size_price + $sauces_cost;
        #-----calculate the total_price----
        
        $sql4 = "INSERT INTO `final_cost` VALUES ('','$total_price_USD','$pizza_id')";
        mysqli_query($this->conn, $sql4);
        

        // // https://api.example.com/exchangerates?base={$baseCurrency}&target={$targetCurrency}&apiKey={$apiKey}
       
        $apiUrl ="https://api.nbrb.by/exrates/rates/431";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl);

        if ($response === false) {

            echo "Error: " . curl_error($curl);

        }else {
            
            #--- Process the API response
            
            $exchangeRateData = json_decode($response, true);
            
            #--- Extract the exchange rate from $exchangeRateData and use it in your pizza ordering system logic
            
            $exchangeRate = $exchangeRateData['Cur_OfficialRate'];

            #--- Get exchange rate
            
            $final_cost_BYN = $exchangeRate * $total_price_USD;
            
            #---change price from USD to BYN

            $sauce_array=[];
            foreach($coyc as $coyc_1){
                $query = mysqli_query($this->conn, "SELECT `name_sauce` FROM `sauce` WHERE `name_sauce`= '$coyc_1'");
                $row = mysqli_fetch_assoc($query);
                array_push($sauce_array,$row['name_sauce']);   
            }
            #---Get all sauces of order from database

            $size_array = [];
            foreach($size as $size_1){
                $query = mysqli_query($this->conn, "SELECT `size_pizza` FROM `size` WHERE `size_pizza`= '$size_1'");
                $row = mysqli_fetch_assoc($query);
                array_push($size_array,$row['size_pizza']);   
            }
            #---Get all sizes of order from database

            echo "Ваш заказ : $typeofpizze";
            echo "<br>";
            echo "Размер :";
            foreach ($size_array as $si){
                echo " $si ," ;
            }
            echo "<br>";
            echo "coyc :";
            foreach ($sauce_array as $sau){
                echo " $sau ," ;
            }
            echo "<br>";
            echo "-------------------------";
            echo "<br>";
            echo "Итого к оплате = $final_cost_BYN BYN ";
            echo "<br>";
            echo "Спасибо за покупку!";

        
        }

        curl_close($curl);
    }

}

?>