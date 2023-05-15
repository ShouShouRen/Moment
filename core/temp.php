<?php



//print data
function printData($id){
    $user = $this->db->prepare("SELECT * FROM users ORDER BY id");
    $user->execute();
    $content = '
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>    
    ';
    while($userInfo = $user->fetch(PDO::FETCH_ASSOC)){
        $content .= '
            <tr>
                <td>'.$userInfo["f_name"].'</td>
                <td>'.$userInfo["l_name"].'</td>
                <td><img style="max-width: 50px;" src="'.$userInfo["avatar"].'" alt="avatar"></td>
                <td>'.$userInfo["email"].'</td>
            </tr>
        ';
    }
    $content .= '</tbody></table>';
    return $content;
}

?>