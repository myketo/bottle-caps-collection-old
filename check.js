function check(){
    if(document.getElementById("marka").value==""){
        if(confirm('Nie wpisałeś nic w pole: Marka.\nCzy na pewno chcesz kontynuować?')){
            return true;
        }else{
            document.getElementById("marka").focus();
            return false;
        }
    }else if(document.getElementById("napis").value==""){
        if(confirm('Nie wpisałeś nic w pole: Napis.\nCzy na pewno chcesz kontynuować?')){
            return true;
        }else{
            document.getElementById("napis").focus();
            return false;
        }
    }else if(document.getElementById("kolor").value==""){
        if(confirm('Nie wpisałeś nic w pole: Kolor.\nCzy na pewno chcesz kontynuować?')){
            return true;
        }else{
            document.getElementById("kolor").focus();
            return false;
        }
    }else if(document.getElementById("kraj").value==""){
        if(confirm('Nie wpisałeś nic w pole: Kraj.\nCzy na pewno chcesz kontynuować?')){
            return true;
        }else{
            document.getElementById("kraj").focus();
            return false;
        }
    }else if(document.getElementById("zdjecie").value==""){
        if(confirm('Nie wpisałeś nic w pole: Zdjecie.\nCzy na pewno chcesz kontynuować?')){
            return true;
        }else{
            document.getElementById("zdjecie").focus();
            return false;
        }
    }
}