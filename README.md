# MarsPack

Marseille WordPress Meetup Plugin Pack

Some useful shortcodes...

## Warning: Don't use with multisite WP


# Usage (Post Content)

```
    SHORTCODE TO DISPLAY A CUSTOM FIELD:

    [pack custom="myKey"]

    SHORTCODE TO DISPLAY THE LINES FROM A TABLE:
    
    [pack table="hello2" custom="hello2"]

    (THE LINE HTML CODE IS IN A CUSTOM FIELD)

    [pack table="hello2"]
    
    SHORTCODE TO CREATE A FORM:

    [pack table="hello2" form="hello2" custom="form"]

    (THE FORM HTML CODE IS IN A CUSTOM FIELD)
    

```

# Usage (Admin) 

```

    SHORTCODE TO CREATE A NEW TABLE:

    [table name="hello2" action="create"]
    [col name="email2" type="email"]
    [col name="nom" type="email"]
    [col name="email3" type="email"]
    [col name="coucou" type="email3"]
    [/table]

    
    SHORTCODE TO INSERT A NEW LINE:

    [table name="hello2" action="insert"]
    [col name="email2" ]Hello[/col]
    [col name="nom" ]Comment ça va[/col]
    [col name="email3" ]zouzou[/col]
    [col name="coucou" ]zeza[/col]
    [/table]

    SHORTCODE TO DROP A TABLE:

    [table name="hello2" action="drop"]
    [/table]

```

## note

This file if for github repository description

