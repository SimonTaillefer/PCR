function selectAll(obj, nb) {                
	for (i=0; i< nb; i++) {        
		document.getElementById(obj.id + i).checked = obj.checked;

		if(obj.checked)
			document.getElementById("tr_"+obj.id+i).className = "select_checked";
		else {
			if(i % 2)
				css = "select_odd"
			else
				css ="select_even";

			document.getElementById("tr_"+obj.id+i).className = css;
		}
	}
}    

function setEvenement(obj, el_id, ev, css_defaut, nb, provenance) {

  //--- recuperation des balises
  comp = document.getElementById(obj);
  tr = document.getElementById("tr_" + obj + el_id);
  ck = document.getElementById(obj + el_id);

  //--- si il s'agit d'un clique
  if(ev == "click") {
      //--- alors on coche ou decoche la checkbox
      if(provenance = "td") ck.checked = !ck.checked;
      
      
      //--- si on decoche, alors on decoche aussi la checkbox du composant            
      if(!ck.checked) {
      	if(comp.checked) comp.checked = false;
      }
      else {

          //---sinon on vérifie que tous les elements sont cochés
          var absent = false;
          var i = 0;
          
          while(i < nb && absent == false)    {                        
          	if(i != el_id) {
          		if(!document.getElementById(obj + i).checked) absent = true;
          	}                    
          	i++;                                
          }
          
          if(comp.checked == absent) comp.checked = !absent;
      }
  }

  //--- autres evenements
  switch(ev) {
  	case "over":
  	tr.className = "select_over";
  	break;

  	case "out":
  	if(ck.checked)
  		tr.className = "select_checked";
  	else
  		tr.className = css_defaut;                    
  	break;        
  }
}
