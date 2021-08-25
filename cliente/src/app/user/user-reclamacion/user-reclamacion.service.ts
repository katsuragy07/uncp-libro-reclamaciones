import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { GlobalConstants } from 'src/app/common/global-constans';
import { Usuario } from "./../../models/usuario.model";
import { Dependencia } from "./../../models/dependencia.model";


@Injectable({
  providedIn: 'root'
})
export class UserReclamacionService {

  
  URI = GlobalConstants.apiURL;

  constructor(private http:HttpClient) { }


  getDependencias(){
    return this.http.get<Dependencia[]>(this.URI+'dependencias/listar_dependencias.php');
  }


  postRegistro(user){
    //console.log(marcar);
    const form_data = new FormData();
    form_data.append('nombre', user.nombre);
    form_data.append('direccion', user.direccion);
    form_data.append('nro_doc', user.nro_doc);
    form_data.append('telefono', user.telefono);
    form_data.append('email', user.email);
    form_data.append('adulto', user.adulto);
    form_data.append('incidencia', user.incidencia);
    form_data.append('dependencia', user.dependencia);
    form_data.append('detalle', user.detalle);
    return this.http.post<any>(this.URI+'marcar/marcar_registrar.php',form_data);
  }


}
