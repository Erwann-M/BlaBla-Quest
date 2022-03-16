
export function convertNumberToDepartement(departements, number) {

  const result = departements.find((departement) => (
    departement.num_dep === String(number)
  ));
  return result;
  
};
