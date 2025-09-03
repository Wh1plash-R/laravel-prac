## System Sitemap and Flows

This document visualizes the key screens and flows for Learners and Instructors.

### Sitemap (high-level)
```mermaid
graph TD
  W[Welcome] --> A[Auth: Login / Register]
  A --> D[Dashboard]

  D -->|Learner| LC[Course Detail (course.view)]
  D -->|Instructor| IC[Instructor Courses (instructor.index)]
  D --> P[Profile]

  LC --> LA[Assignment (assignment.view)]
  LA --> LS[Submit / Finalize / Download]

  IC --> ICC[Course Detail (instructor.course.view)]
  ICC --> IAnn[Announcements]
  ICC --> IAsg[Assignments]
  IAsg --> IAView[Assignment (instructor.assignment.view)]
  IAView --> IAct[Download / Grade / Lock-Unlock]
```

### Flowchart (role-based app flow)
```mermaid
flowchart TD
  start([Visit Welcome]) --> auth{Login or Register}
  auth --> dash[Dashboard]
  dash -->|Learner| l_course[Open Course (course.view)]
  l_course --> l_assgn[Open Assignment (assignment.view)]
  l_assgn --> l_submit[Submit / Finalize / Download]
  dash -->|Instructor| i_index[Instructor Courses (instructor.index)]
  i_index --> i_course[Open Course (instructor.course.view)]
  i_course --> i_ann[Post Announcements]
  i_course --> i_assgn[Open Assignment (instructor.assignment.view)]
  i_assgn --> i_actions[Download / Grade / Lock-Unlock]
  dash --> prof[Profile]
  prof --> dash
  l_submit --> dash
  i_actions --> dash
```

### Sequence: Learner submits assignment
```mermaid
sequenceDiagram
  actor Learner
  participant UI as Blade (Learner)
  participant LC as LearnerController
  participant DB as Eloquent/DB
  participant FS as Storage (public)

  Learner->>UI: Open Assignment (assignment.view)
  UI->>LC: POST assignment.submit (file, comments)
  LC->>FS: store file
  LC->>DB: create/update Submission
  DB-->>LC: Submission saved
  LC-->>UI: Redirect with success
  UI-->>Learner: Shows submitted status
```

### Sequence: Instructor grades submission
```mermaid
sequenceDiagram
  actor Instructor
  participant UI as Blade (Instructor)
  participant IC as InstructorController
  participant DB as Eloquent/DB

  Instructor->>UI: Open Assignment (instructor.assignment.view)
  UI->>IC: POST instructor.assignment.grade (learner_id, grade, feedback)
  IC->>DB: update Submission.grade & feedback
  DB-->>IC: Updated
  IC-->>UI: Redirect with success
  UI-->>Instructor: Shows updated grade
```
