import './styles.scss';
import RoutesDisconnected from '../../Routes/RoutesDisconnected';
import RoutesConnected from '../../Routes/RoutesConnected';
import { useSelector } from 'react-redux';
import { useLocation } from 'react-router-dom';
import { useEffect } from 'react';

function App() {

  const {logged } = useSelector(state => state.user)
  const {pathname} = useLocation()
  
  useEffect(() => (
    window.scrollTo(0,0)
  ), [pathname]);

  return (
    <div className="App">
      {!logged && <RoutesDisconnected />}
      {logged && <RoutesConnected />}
    </div>
  );
}

export default App;
