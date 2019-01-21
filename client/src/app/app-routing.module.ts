import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { UsersComponent } from './users/users.component';
import { UserCreateComponent } from './user-create/user-create.component';
import { UserImportComponent } from './user-import/user-import.component';
import { UserViewComponent } from './user-view/user-view.component';

const routes: Routes = [
  {
    path: 'import',
    component: UserImportComponent,
    data: { title: 'Import' }
  },
  {
    path: 'edit/:id',
    component: UserCreateComponent,
    data: { title: 'Edit' }
  },
  {
    path: 'create',
    component: UserCreateComponent,
    data: { title: 'Create' }
  },
  {
    path: 'user/:id',
    component: UserViewComponent,
    data: { title: 'User' }
  },
  {
    path: 'users/:page',
    component: UsersComponent,
    data: { title: 'Users' }
  },
  {
    path: 'users',
    component: UsersComponent,
    data: { title: 'Users' }
  },
  { path: '',
    redirectTo: '/users',
    pathMatch: 'full'
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})

export class AppRoutingModule { }