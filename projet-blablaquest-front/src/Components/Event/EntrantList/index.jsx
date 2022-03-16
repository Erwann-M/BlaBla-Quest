import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Typography from '@mui/material/Typography';
import Modal from '@mui/material/Modal';
import { useState } from 'react';
import defaultImage from '../../../assets/img/default.jpg';
import './styles.scss'


const style = {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 400,
    bgcolor: '#dcdfee',
    border: '2px solid #000',
    boxShadow: 24,
    p: 4,
  };

export default function EntrantList({ participations }) {
    const [open, setOpen] = useState(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);
  
    return (
      <div>
        <Button style={{backgroundColor: "orange", color: "black", fontWeight: "700"}} onClick={handleOpen}>Liste des participants</Button>
        <Modal
          open={open}
          onClose={handleClose}
          aria-labelledby="modal-modal-title"
          aria-describedby="modal-modal-description"
        >
          <Box sx={style} className="container__modal">
              {
                  participations.filter(participation => participation.isValidated).map(participant => (
                    <Typography id="modal-modal-description" sx={{ mt: 2, display: 'flex'}}>
                        <div className="entrant__user" >
                          <img className='image__user' src={defaultImage} alt={participant.user.nickname} />
                            {participant.user.nickname}
                            <button className="entrant__user--button">x</button>
                        </div>
                    </Typography>

                  ))
              }
          </Box>
        </Modal>
      </div>
    );
  }