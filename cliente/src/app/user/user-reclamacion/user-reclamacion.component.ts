import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';


import { UserReclamacionService } from "./user-reclamacion.service";
import { Usuario } from "./../../models/usuario.model";
import { Dependencia } from "./../../models/dependencia.model";

import * as $ from 'jquery';
declare var $: any;

@Component({
  selector: 'app-user-reclamacion',
  templateUrl: './user-reclamacion.component.html',
  styleUrls: ['./user-reclamacion.component.css']
})
export class UserReclamacionComponent implements OnInit {

  user: Usuario;
  dependencias: Dependencia[];
  btn: boolean;
  msg_res: string;
  capcha: boolean;
  
  siteKey: string;

  constructor(private service: UserReclamacionService, private toastr: ToastrService){
    this.user = new Usuario();;
    this.dependencias = [];
    this.btn = true;
    this.msg_res = "";
    this.capcha = false;
    this.siteKey = "6LfDlhscAAAAAM3ACXDcgO0WUyLGh0L7qFXONwLO";
  }


  ngOnInit(): void {
    this.getDependencias();
  }

  

  getDependencias(){
    this.service.getDependencias().subscribe(res=>{
      this.dependencias = res;
    },
    err=>{
      console.log(err);
    });
  }


  submit(form){
    if(this.capcha){ 
      this.btn = false;
      this.service.postRegistro(this.user).subscribe(
        res=>{
          //console.log(res)
          if(res.res==200){
            this.msg_res = res.id;
            $("#btn_seg").html(`<a href="https://gestionuncp.edu.pe/tramite/vecinos/seguimiento.php?pk=${res.id}" class="btn btn-success d-inline ps-5 pe-5" target="_blank">Ver Detalles</a>`);
            $("#state_bar").html(``);
            $("#modal_confirm").modal('show');
            this.resetForm(form);
            this.btn = true;
          }else{
            this.btn = true;
            $("#state_bar").html(`
              <div class="alert alert-warning" role="alert">
                  No se puedo registrar su caso correctamente!. Error 
                  ${res.res}
              </div>
            `);
            //console.log(res);
          }
        },
        err=>{
          console.log(err)
          this.btn = true;
          $("#state_bar").html(`
              <div class="alert alert-warning" role="alert">
                  ${err.message}
                </div>
            `);
          console.log(err);
        }
      );
    }else{
      this.toastr.error('Completa el Capcha para validar tu identidad.','Aviso');
    }
  }
  


  resetForm(getForm){
    getForm.resetForm();
    this.user = new Usuario();
  }

  
  capchaSucces(e){
   this.capcha = true;
  }
  capchaReset(){
    this.capcha = false;
  }

}
