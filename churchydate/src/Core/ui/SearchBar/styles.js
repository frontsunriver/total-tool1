import { StyleSheet } from 'react-native';

const dynamicStyles = (appStyles, colorScheme) => {
  return StyleSheet.create({
    container: {
      // width: Platform.OS === 'ios' ? '120%' : '100%',
      width: '95%',
      alignSelf: 'center',
      marginBottom: 4,
    },
    cancelButtonText: {
      color: appStyles.colorSet[colorScheme].mainThemeForegroundColor,
      fontSize: 16,
      marginBottom: 5,
    },
    searchInput: {
      fontSize: 16,
      color: appStyles.colorSet[colorScheme].mainTextColor,
      backgroundColor: appStyles.colorSet[colorScheme].whiteSmoke,
    },
  });
};

export default dynamicStyles;
