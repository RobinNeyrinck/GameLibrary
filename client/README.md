# Game Library Frontend - Group 34
## How to deploy
1. Clone the repository
2. Run the following commands in the root directory
    ### Install Dependencies
    ```sh
    npm install
    ```
    ### Compile and Hot-Reload for Development
    ```sh
    npm run dev
    ```
    ### Compile and Minify for Production
    ```sh
    npm run build
    ```

## Features
- Login page
- Register page + token saved in session storage (not local storage for security purposes)
- Library page (with pagination filter)
- Simple home/landing page
- Add game page
- Edit game page
- Delete game

## Known Bugs
- Pagination in admin page is not set up, this could be done by adding the pagination component to the admin page.
- Pagination on library page only works when clicking on `submit`
- Tags and filter are not translated in the filtering component

## Important Notes
- For the login, first you have to register and after that you can login with the email and password you used to register.
- When trying to switch pages in library page, you have to click on `submit` for the pagination to work.
- When you have already filtered, your last filters will be preloaded after page reload.
- After login, your token is only stored for the session, so when you close the window, you have to login again.