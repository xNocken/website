const getUrlEncodedString = (args) => {
  const strings = [];
  Object.entries(args).forEach((arg) => {
    strings.push(`${arg[0]}=${arg[1]}`);
  });

  return strings.join('&');
};

export default (route, args, callback, method = 'POST') => {
  const request = new XMLHttpRequest();

  request.open(method, route);
  request.onload = () => {
    callback(request);
  };
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send(getUrlEncodedString(args));
};
