var a;
document.addEventListener("DOMContentLoaded", function(event) {
    console.log("DOM completamente carregado e analisado");

    

    document.addEventListener('change', function(){
    	var opcao = document.getElementById('tableSelector');
    	if (opcao.selectedIndex === 0 ) {
    		document.getElementById('tableUsuario').hidden = false;
    		document.getElementById('tableFuncao').hidden = true;
    	}
    	else if (opcao.selectedIndex === 1 ) {
    		document.getElementById('tableUsuario').hidden = true;
    		document.getElementById('tableFuncao').hidden = false;
    	}
    	else if (opcao.selectedIndex === 2 ) {
    		document.getElementById('tableUsuario').hidden = false;
    		document.getElementById('tableFuncao').hidden = false;
    	}
    })

  });