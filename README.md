# GLIDE - The Land Institute WordPress Project

This is a WordPress repository configured to run on the [WP Engine platform](https://wpengine.com/support/deploying-code-with-bitbucket-pipelines-wp-engine/).

## Project Overview

The Land Institute project is a custom WordPress theme built with NodeJS, Composer, and WebPack. This repository contains the theme code and configuration required for the project.

- **Project Name:** The Land Institute
- **Theme Name:** Land Institute
- **Theme Location:** `/wp-content/themes/landinstitute`
- **NodeJS Version:** 18.15.0
- **Composer:** Required for theme setup
- **Branches:**
  - `main` (Production)
  - `development` (Development)
- **Production Site:** [https://landinstitute.org/](https://landinstitute.org/)
- **Development Site:** [https://landinstdev.wpenginepowered.com/](https://landinstdev.wpenginepowered.com/)

## Branches

### Master Branch

- **Connected to:** WPE Production Install [landinst](https://my.wpengine.com/installs/landinst)
- **URL:** [https://landinstitute.org/](https://landinstitute.org/)
- **Pipeline:** Bitbucket pipeline for deploying code to the production environment

### Development Branch

- **Connected to:** WPE Development Install [landinstdev](https://my.wpengine.com/installs/landinstdev)
- **URL:** [https://landinstdev.wpenginepowered.com/](https://landinstdev.wpenginepowered.com/)
- **Pipeline:** Bitbucket pipeline for deploying code to the development environment

## Setup Instructions

### Prerequisites

- Ensure you have NodeJS version 18.15.0 installed.
- Ensure Composer is installed on your system.

### Initial Setup

1. **Clone the Repository:**

   This is a private repository, so you need to authenticate with your Bitbucket account. Use the following command to clone the repository:

   ```sh
   git clone https://<your-username>@github.com/GlideSupport/landinstitute.git
   cd landinstitute
   ```

2. **Switch to the Desired Branch:**

   ```sh
   # For development branch
   git checkout development

   # For main branch
   git checkout main
   ```

3. **Setup Theme Dependencies:**

   ```sh
   cd wp-content/themes/landinstitute
   npm run setup
   ```

4. **Start Development Server:**

   ```sh
   npm run start
   ```

5. **Build Assets:**

   ```sh
   npm run build
   ```

### Deployment

Deployments are handled automatically through Bitbucket pipelines. Any code pushed to the `development` or `master` branches will be deployed to their respective WPE environments.

## Bitbucket Pipelines

The repository uses Bitbucket Pipelines for CI/CD. The pipeline configuration ensures that code is tested and deployed to the correct environment based on the branch.

### Pipeline Configuration

- **Master Branch:**

  - Deploys to: [https://landinstitute.org/](https://landinstitute.org/)

- **Development Branch:**

  - Deploys to: [https://landinstdev.wpenginepowered.com/](https://landinstdev.wpenginepowered.com/)

---

If you have any further questions or need assistance with specific aspects of the The Land Institute project, feel free to ask!