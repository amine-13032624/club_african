# Team Management Module - Complete CRUD Implementation

## Overview
The team (Équipe) management module is now fully functional with complete CRUD operations implemented across the Model, Controller, and View layers following the MVC pattern.

## Module Structure

### Views (Frontend)
- **`views/equipes/liste.php`** - List all teams in responsive grid layout
  - Displays team cards with colors, details, and action buttons
  - Actions: View (Voir), Edit (Éditer), Delete (Supprimer)
  - Empty state with link to create first team
  - Uses cards layout with hover effects

- **`views/equipes/ajouter.php`** - Form to create new team
  - Fields: nom, sport, nombre_joueurs, id_entraineur_principal, couleur_principale, couleur_secondaire
  - Includes trainer dropdown from database
  - Color pickers for team colors
  - Validates form before submission
  - Async submission via Fetch API

- **`views/equipes/editer.php`** - Form to edit existing team
  - Pre-fills all fields with current team data
  - Same fields as add form
  - Trainer dropdown with current trainer selected
  - Color pickers showing current colors
  - Validates form before submission
  - Async submission via Fetch API

- **`views/equipes/profil.php`** - Team detail/profile page
  - Displays team information with color indicators
  - Shows team colors with hex codes
  - Lists all athletes in the team (table format)
  - Edit and Delete buttons
  - Shows athlete details: nom, prenom, email, date_inscription
  - Link to athlete profiles

### Controllers
- **`controllers/EquipeController.php`** - CRUD controller with 12 methods
  ```
  - ajouter($data)              // CREATE: Add new team
  - getTousEquipes()            // READ: Get all teams with trainer info
  - getEquipeById($id)          // READ: Get single team by ID
  - getAthletes($id_equipe)     // READ: Get athletes in team
  - modifier($id, $data)        // UPDATE: Modify team
  - supprimer($id)              // DELETE: Remove team
  - ajouterAthlete($id_equipe, $id_athlete)  // Associate athlete with team
  - getStatistiques($id_equipe) // Get team statistics
  - creer($data)                // Alias for ajouter()
  - getEquipesAvecDetails()     // Get all with full details
  - countEquipes()              // Count total teams
  - rechercherParNom($nom)      // Search teams by name
  ```

### API Endpoints
- **`api/equipe/ajouter.php`** - REST endpoint for team creation
  - Method: POST
  - Input: JSON with team data
  - Output: JSON {success: bool, message: string, data?: object}

- **`api/equipe/modifier.php`** - REST endpoint for team updates
  - Method: POST
  - Input: JSON with id and team data
  - Output: JSON response with success status

- **`api/equipe/supprimer.php`** - REST endpoint for team deletion
  - Method: POST
  - Input: JSON with team id
  - Output: JSON response with success status

### Model
- **`models/Equipe.php`** - Team model with diagram methods
  ```
  - creer()              // Create team
  - ajouterAthlete()     // Add athlete to team
  - suivreEquipe()       // Track team
  + database operations for team management
  ```

## User Workflows

### Create Team
1. User clicks "Ajouter une équipe" button
2. Navigated to `views/equipes/ajouter.php`
3. Fills in team details (name, sport, athletes, trainer, colors)
4. Submits form via JavaScript Fetch API
5. Form sent to `api/equipe/ajouter.php`
6. Controller validates and inserts into database
7. User sees success message and redirected to list

### Read/View Teams
1. User accesses `views/equipes/liste.php`
2. All teams displayed in responsive grid
3. Each team card shows: name, sport, player count, trainer, creation date, colors
4. User can click "Voir" to see team details page (`profil.php`)
5. Details page shows team info and all associated athletes

### Update Team
1. User clicks "Éditer" button on team card
2. Navigated to `views/equipes/editer.php?id=X`
3. Form pre-filled with current team data
4. User edits any fields (name, sport, trainer, colors, etc.)
5. Submits form via JavaScript Fetch API
6. Form sent to `api/equipe/modifier.php`
7. Controller validates and updates database
8. User sees success message and redirected to list

### Delete Team
1. User clicks "Supprimer" button on team card or detail page
2. Confirmation dialog appears
3. If confirmed, JavaScript sends DELETE request to `api/equipe/supprimer.php`
4. Controller deletes team from database
5. Page reloads showing updated team list

## Key Features

✅ **Full CRUD Operations**
- Create new teams with all required fields
- Read/view single team or all teams
- Update team details
- Delete teams with confirmation

✅ **Responsive Design**
- Grid layout adapts to screen size
- Mobile-friendly forms and tables
- Proper styling with CSS

✅ **Form Validation**
- Client-side validation with HTML5 required fields
- Server-side validation in controller
- Error messages displayed to user

✅ **Data Integrity**
- Foreign key constraints for trainer assignment
- Cascade delete if needed
- Proper error handling

✅ **User Experience**
- Color indicators showing team colors
- Dropdown selection for trainers
- Confirmation dialogs for destructive actions
- Success/error messages
- Async form submission without page reload

✅ **Database Integration**
- Proper joins to display trainer information
- Member_equipe pivot table for athlete association
- All data properly stored and retrieved

## Database Tables Used
- `equipe` - Main team table
- `entraineur` - Coach/trainer table (joined for display)
- `membre` - Member table (for athletes)
- `membre_equipe` - Pivot table for team-athlete association

## Error Handling
- Invalid team IDs handled gracefully
- Missing required fields validated and flagged
- Database errors caught and displayed
- Confirmation dialogs prevent accidental deletions

## Next Steps for Enhancement
1. Add team statistics visualization
2. Implement athlete performance tracking per team
3. Add team filter/search functionality
4. Create team analytics dashboard
5. Add bulk team operations
6. Implement team history/audit log
