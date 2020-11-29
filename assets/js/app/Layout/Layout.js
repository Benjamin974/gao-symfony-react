import React, { Component } from 'react';
import { Route, Link, BrowserRouter } from 'react-router-dom';
import Ordi from '../views/PageOrdi'
import Login from '../login/login'
class Layout extends Component {
  render() {
    return (
      <div>
        <BrowserRouter>
          <ul>
            <li><Link to="/ordinateurs">Ordinateurs</Link></li>
            <li><Link to="/login">Login</Link></li>
          </ul>


          <Route path="/ordinateurs" component={Ordi} />
          <Route path="/login" component={Login} />
        </BrowserRouter>
      </div>
    );
  }
}

export default Layout;