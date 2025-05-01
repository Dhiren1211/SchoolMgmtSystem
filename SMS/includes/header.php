<Header>
    <nav>
        <div class="left">
            <img src="images/logo.png" alt="logo" srcset="">
            <a href="index.php"><h2>SMS</h2></a>
        </div>
        <div class="right">
            <ul>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>
    </nav>
</Header>
<style>
    a{
        text-decoration: none;
        color: white;
    }
    Header{
        background-color:  rgba(7, 31, 36, 0.45);
        color:white;
        height:70px;
        border-radius: 5px;
        padding:10px;
        
    }
    header nav{
      
        display: flex;
        justify-content: space-between;
        align-items: center;
        height:70px;
        padding: 0px;
    }
    header nav .left{
        display: flex;
        align-items: center;
        gap: 10px;
    }
    header nav .right ul{
        display: flex;
        gap: 30px;
        
    }
    header nav .left img{
        height:50px;
    }
    header nav .right ul li,
    header nav .right ul li a{
        list-style: none;
        color: white;
        text-decoration:none;
    }
</style>