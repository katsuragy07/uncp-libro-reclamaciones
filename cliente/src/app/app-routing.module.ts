import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { UserReclamacionComponent } from './user/user-reclamacion/user-reclamacion.component';


const routes: Routes = [
  {
    path: '', 
    component: UserReclamacionComponent,
    children: [
      {
        path: '',
        component: UserReclamacionComponent
      }
    ]
  }

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
