// Import 
import './styles.scss';
import ConnectionForm from './ConnectionForm';
import ProfileForm from "./ProfileForm";
import logo from '../../assets/img/logo.png';
import { toggleLoginForm, toggleProfileModal, logout } from '../../action/user';

// Import MUI
import ContrastIcon from '@mui/icons-material/Contrast';
import PersonIcon from '@mui/icons-material/Person';
import HowToRegIcon from '@mui/icons-material/HowToReg';
import { useDispatch, useSelector } from 'react-redux';
import { NavLink } from 'react-router-dom';
import { setAreaMap } from '../../action/event';


const Header = () => {
  
  const { logged, loginForm, profileModal, currentUser } = useSelector((state) => state.user);

  // console.log(currentUser.roles[0]);

  const dispatch = useDispatch();

  const handleClick = () => {
    dispatch(toggleLoginForm());
  };

  const handleClickProfile = () => {
    dispatch(toggleProfileModal())
  }

  const handleDeconnection = () => {
    dispatch(logout())
  }

  const handleClickLogo = () => {
    dispatch(setAreaMap(0));
  };

  return (
    <div className="header">
      <div className="navbar">

        <div onClick={handleClickLogo} className="navbar__main-logo">
          <NavLink to="/"><img alt="logo" className="navbar__logo" src={logo} /></NavLink>
        </div>

        <div className="navbar__profile">
          {!logged && <div className="navbar__profile--mobile">
            <NavLink to="/registration">
              <button className="navbar__profile__button">
                <PersonIcon style={{ fontSize: 40 }} />
              </button>
            </NavLink>
              <button className="navbar__profile__button" onClick={handleClick}>
                <HowToRegIcon style={{ fontSize: 40 }} />
              </button>
          </div>}
          
          {!logged && <div className="navbar__profile--desktop">
            <NavLink to="/registration">
              <button className="profile-btn register-btn">S'inscrire</button>
            </NavLink>
              <button className="profile-btn connect-btn" onClick={handleClick}>Se connecter</button>
          </div>}
          {logged && <div className="navbar__profile--desktop">
            {
              currentUser.roles[0] === "ROLE_ADMIN" && 
              <a href="http://15.188.23.49/admin/login" className='profile-btn admin-btn'>Administration</a>
            }
            <NavLink to="/" >
              <button className="profile-btn register-btn" onClick={handleDeconnection}>Se déconnecter</button>
            </NavLink>
          
            <button className="profile-btn connect-btn" onClick={handleClickProfile}>Mon profil</button>
          </div>}
          {/* {logged && <img
            alt="profile"
            className="profile-picture"
            src={defaultProfilePicture}
            onClick={handleClickProfile}
            />} */}
        </div>
        
      </div>
        { loginForm && <ConnectionForm /> }
        { profileModal && <ProfileForm /> }
    </div>
  );
}

export default Header;
