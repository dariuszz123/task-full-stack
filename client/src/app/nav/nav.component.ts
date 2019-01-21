import { Component } from '@angular/core';
import { BreakpointObserver, Breakpoints } from '@angular/cdk/layout';
import { Observable } from 'rxjs';
import { map, filter } from 'rxjs/operators';
import { Router, NavigationEnd } from '@angular/router';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss']
})
export class NavComponent {
  public title = 'CRUD';
  isHandset$: Observable<boolean> = this.breakpointObserver.observe(Breakpoints.Handset)
    .pipe(
      map(result => result.matches)
    );

  constructor(private breakpointObserver: BreakpointObserver, private router:Router) {
    this.router.events.subscribe(event => {
      if(event instanceof NavigationEnd) {
        try {
          this.router.routerState.root.firstChild.data.subscribe((data) => {
            this.title = data.title;
          })
        } catch(err) {

        }
      }
    });
  }

}
