import React from 'react';
import ReactDOM from 'react-dom';
import './styles.scss';
import App from './Components/App';
import {BrowserRouter} from 'react-router-dom';
import {Provider} from 'react-redux'
import store from './store'


ReactDOM.render(
  <BrowserRouter>
    <React.StrictMode>
      <Provider store={store}>
        <App />
      </Provider>
    </React.StrictMode>
  </BrowserRouter>,
  document.getElementById('root')
);

