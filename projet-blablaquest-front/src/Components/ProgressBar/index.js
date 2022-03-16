import * as React from 'react';
import PropTypes from 'prop-types';
import LinearProgress from '@mui/material/LinearProgress';
import Box from '@mui/material/Box';
import { useSelector } from 'react-redux';

function LinearProgressWithLabel(props) {
    const { nbrOfPlayers, nbrOfPlayersMax } = useSelector(state => state.event.eventSaved)

    const progress = (2 / 5) * 100

    console.log(progress);

  return (
    <Box>
      <LinearProgress variant="determinate" {...props} />
    </Box>
  );
}

LinearProgressWithLabel.propTypes = {
  /**
   * The value of the progress indicator for the determinate and buffer variants.
   * Value between 0 and 100.
   */
  value: PropTypes.number.isRequired,
};

export default function LinearWithValueLabel({nbrOfPlayers, nbrOfPlayersMax}) {


    const progress = (nbrOfPlayers / nbrOfPlayersMax) * 100

    return (
        <Box sx={{ width: '100%' }}>
            <LinearProgressWithLabel value={progress} />
        </Box>
    );
}