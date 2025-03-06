# How to use Srsly theme

## 1. Install

1. Install Node.js - https://nodejs.org/
2. Install all dependencies - open the terminal, make sure the current path is the root folder, and run the "npm i" command without brackets.

## 2. Two Commands

npm run dev - for development. Watches all files in assets/src and compiles unminified CSS and JS files in assets/dist in real-time. Change the localDomain variable in webpack.config.js to your current website URL.

npm run build - before pushing live. Compiles all files from assets/src into minified CSS and JS files in assets/dist.

Rerun the command after changing webpack.config.js.

To stop the "npm run dev" command, press:
cmd+c (MAC) or ctrl+c (WIN).

## 3. File Structure

Input JS and SCSS - src

Output JS and CSS - dist

DO NOT DELETE any of these files:

- package-lock.json
- package.json
- postcss.config.js
- webpack.config.js
