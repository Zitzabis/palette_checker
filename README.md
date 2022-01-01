# Palette Battle League PMC Voter
This project was initially created to test a script that would check Minecraft skins for compliance with a predefined palette. Legacy information for this is provided below:
<details>
  <summary>Click to expand!</summary>
  
  # Minecraft Skin Palette Checker

    ## Introduction
    This is an example website that makes use of the [Palette Matcher API](https://github.com/Zitzabis/palette_matcher).

    ## Preview
    ![Example](https://i.imgur.com/ZNdXLn8.png "Example")

    ## TODO
    - Parse PMC skin links and extract the direct URL. This will be replicated on Palette Matcher API.
</details>
<hr>

## Introduction
This website works alongside the Planet Minecraft community to provide extended tools and resources for specific contest formats.

The primary contest format this site was designed for, is the Palette Battle League. Where weekly rounds are held on Planet Minecraft using a bracket system. Each week, a palette is provided to the contestents. These skins are voted on by the community using a polling system and the winner moves forward in the bracket.

The community has found that using the Planet Minecraft polling system poses some limitations. This site aims to address the following:

1. Name Bias

    It has commonly been argued that people will vote for a skin based on who made it. This is an avoidable issue and can not be entirely solved without making the entire system anonymous and limiting when contestants are able to publically publish their skins on PMC.

    Previous/current PMC polls display the names of the artist and this lead to some people making accusations of favortism and bias in the votes.

    As such, names are not displayed when the poll is live. This helps avoid some degree of bias for the random voter.
    However, this does not prevent contestants from posting their skin whenever they want.

    Neither does it prevent people from recognizing the style of a skin belonging to a certain skinner.

    It is an avoidable issue but we have taken steps to mitigate bias when the skin is presented.
2. Presentation Bias

    Following on from the above, this site aims to remove any bias in the poll presentation. It is standardized for everyone and includes 2D and 3D previews to allow skins to be shown at their fullest potential.

3. Bracket Creation

    Bracket creation on PMC is non-existent and must be done manually using Photoshop or something similar.
    This site aims to resolve this by providing tools that automatically create brackets for the contests.

4. Palette Checking

    When skins are uploaded to this site, they have the option to be validated using a palette defined for that contest. A script will check all relevant pixels in the skin file to ensure that they have used ONLY the colors predefined. If it fails the validation, the skin will not be able to be entered.

    This script will ignore any blank spaces and only look at skin parts.