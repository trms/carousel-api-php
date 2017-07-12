<?php namespace CarouselTests\MockData;

class MockResponder
{

  static function whoAmI()
  {
    $data = [
      'id' => 'admin',
      'Locale' => 'en',
    ];

    return json_encode($data);
  }

  static function user()
  {
    $data = [
      'id' => 'admin',
      'FirstName' => 'Seth',
      'LastName' => 'Phillips',
      'EmailAddress'=> 'test@email.com',
      'DefaultZoneID'=> 1,
      'IsAdmin'=> true,
      'SystemRights'=> [],
      'ZoneRights' => []
    ];

    return json_encode($data);
  }



  static function bulletins()
  {
    $data = [
      [
        "id"=> "1",
        "GroupID"=> "1",
        "UserID"=> "admin",
        "IsAlert"=> true,
        "Status"=> "Current",
        "Type"=> "Standard",
        "Description"=> "This is a test bulletin",
        "DateTimeOn"=> "2017-07-07T14:20:57.191Z",
        "DateTimeOff"=> "2017-07-07T14:20:57.191Z",
        "CycleTimeOff"=> "2017-07-07T14:20:57.191Z",
        "CycleTimeOn"=> "2017-07-07T14:20:57.191Z",
        "WeekdayOnOff"=> 64,
        "WeekdayOnOffDescription"=> "Every Day",
        "IsRepeating"=> true,
        "RepeatInterval"=> 0,
        "IsScheduled"=> false,
        "LastUpdate"=> "2017-07-07T14:20:57.191Z",
        "ImpressionCount"=> 0,
        "TrackImpressions"=> true,
        "LastError"=> "string",
        "Tags"=> [
          [
            "id"=> 1,
            "TagName"=> "Test Tag"
          ]
        ],
        "TransitionID"=> "1",
        "UseSystemDwellTime"=> true,
        "DwellTime"=> 0,
        "SoundID"=> "1",
        "WebEnabled"=> true,
        "Notified"=> true,
        "CustomDescription"=> true,
        "SuppressBackgroundAudio"=> true,
        "IsDeleted"=> false,
        "IsMigrated"=> true,
        "IsCorrupt"=> false,
        "BackgroundID"=> "1",
        "Blocks"=> [
          [
            "BlockType"=> "Rectangle",
            "Height"=> 0,
            "Width"=> 0,
            "X"=> 0,
            "Y"=> 0,
            "RectColor"=> "string",
            "RectColorOpacity"=> 0,
            "RectShadow"=> true,
            "RectShadowColor"=> "string",
            "RectShadowOpacity"=> 0,
            "RectShadowDepth"=> 0,
            "RectOutline"=> true,
            "RectOutlineColor"=> "string",
            "RectOutlineOpacity"=> 0,
            "RectOutlineWidth"=> 0,
            "RectGradient"=> true,
            "RectGradientMode"=> "BackwardDiagonal",
            "RectGradientColor"=> "string",
            "RectGradientOpacity"=> 0,
            "RotateDegrees"=> 0,
            "Reflection"=> true,
            "ReflectionOpacity"=> 0,
            "ReflectionOffset"=> 0,
            "ReflectionHeight"=> 0,
            "Name"=> "string",
            "HTMLFieldType"=> "EditField",
            "HTMLFieldSize"=> "Small",
            "RepeatType"=> "Header"
          ]
        ],
      ],
      [
        "id"=> "2",
        "GroupID"=> "2",
        "UserID"=> "admin",
        "IsAlert"=> true,
        "Status"=> "Current",
        "Type"=> "Standard",
        "Description"=> "This is a test bulletin",
        "DateTimeOn"=> "2017-07-07T14:20:57.191Z",
        "DateTimeOff"=> "2017-07-07T14:20:57.191Z",
        "CycleTimeOff"=> "2017-07-07T14:20:57.191Z",
        "CycleTimeOn"=> "2017-07-07T14:20:57.191Z",
        "WeekdayOnOff"=> 127,
        "WeekdayOnOffDescription"=> "Every Day",
        "IsRepeating"=> false,
        "RepeatInterval"=> 0,
        "IsScheduled"=> false,
        "LastUpdate"=> "2017-07-07T14:20:57.191Z",
        "ImpressionCount"=> 0,
        "TrackImpressions"=> true,
        "LastError"=> "string",
        "Tags"=> [
          [
            "id"=> 1,
            "TagName"=> "Test Tag"
          ]
        ],
        "TransitionID"=> "1",
        "UseSystemDwellTime"=> true,
        "DwellTime"=> 0,
        "SoundID"=> "1",
        "WebEnabled"=> true,
        "Notified"=> true,
        "CustomDescription"=> true,
        "SuppressBackgroundAudio"=> true,
        "IsDeleted"=> false,
        "IsMigrated"=> true,
        "IsCorrupt"=> false,
        "BackgroundID"=> "1",
        "Blocks"=> [
          [
            "BlockType"=> "Rectangle",
            "Height"=> 0,
            "Width"=> 0,
            "X"=> 0,
            "Y"=> 0,
            "RectColor"=> "string",
            "RectColorOpacity"=> 0,
            "RectShadow"=> true,
            "RectShadowColor"=> "string",
            "RectShadowOpacity"=> 0,
            "RectShadowDepth"=> 0,
            "RectOutline"=> true,
            "RectOutlineColor"=> "string",
            "RectOutlineOpacity"=> 0,
            "RectOutlineWidth"=> 0,
            "RectGradient"=> true,
            "RectGradientMode"=> "BackwardDiagonal",
            "RectGradientColor"=> "string",
            "RectGradientOpacity"=> 0,
            "RotateDegrees"=> 0,
            "Reflection"=> true,
            "ReflectionOpacity"=> 0,
            "ReflectionOffset"=> 0,
            "ReflectionHeight"=> 0,
            "Name"=> "string",
            "HTMLFieldType"=> "EditField",
            "HTMLFieldSize"=> "Small",
            "RepeatType"=> "Header"
          ]
        ],
      ]
    ];

    return json_encode($data);
  }

  static function bulletin()
  {
    $data = [
      "id"=> "1",
      "GroupID"=> "1",
      "UserID"=> "admin",
      "IsAlert"=> true,
      "Status"=> "Current",
      "Type"=> "Standard",
      "Description"=> "This is a test bulletin",
      "DateTimeOn"=> "2017-07-07T14:20:57.191Z",
      "DateTimeOff"=> "2017-07-07T14:20:57.191Z",
      "CycleTimeOff"=> "2017-07-07T14:20:57.191Z",
      "CycleTimeOn"=> "2017-07-07T14:20:57.191Z",
      "WeekdayOnOff"=> 64,
      "WeekdayOnOffDescription"=> "Every Day",
      "IsRepeating"=> true,
      "RepeatInterval"=> 0,
      "IsScheduled"=> false,
      "LastUpdate"=> "2017-07-07T14:20:57.191Z",
      "ImpressionCount"=> 0,
      "TrackImpressions"=> true,
      "LastError"=> "string",
      "Tags"=> [
        [
          "id"=> 1,
          "TagName"=> "Test Tag"
        ]
      ],
      "TransitionID"=> "1",
      "UseSystemDwellTime"=> true,
      "DwellTime"=> 0,
      "SoundID"=> "1",
      "WebEnabled"=> true,
      "Notified"=> true,
      "CustomDescription"=> true,
      "SuppressBackgroundAudio"=> true,
      "IsDeleted"=> false,
      "IsMigrated"=> true,
      "IsCorrupt"=> false,
      "BackgroundID"=> "1",
      "Blocks"=> [
        [
          "BlockType"=> "Rectangle",
          "Height"=> 0,
          "Width"=> 0,
          "X"=> 0,
          "Y"=> 0,
          "RectColor"=> "string",
          "RectColorOpacity"=> 0,
          "RectShadow"=> true,
          "RectShadowColor"=> "string",
          "RectShadowOpacity"=> 0,
          "RectShadowDepth"=> 0,
          "RectOutline"=> true,
          "RectOutlineColor"=> "string",
          "RectOutlineOpacity"=> 0,
          "RectOutlineWidth"=> 0,
          "RectGradient"=> true,
          "RectGradientMode"=> "BackwardDiagonal",
          "RectGradientColor"=> "string",
          "RectGradientOpacity"=> 0,
          "RotateDegrees"=> 0,
          "Reflection"=> true,
          "ReflectionOpacity"=> 0,
          "ReflectionOffset"=> 0,
          "ReflectionHeight"=> 0,
          "Name"=> "string",
          "HTMLFieldType"=> "EditField",
          "HTMLFieldSize"=> "Small",
          "RepeatType"=> "Header"
        ]
      ],
    ];

    return json_encode($data);
  }

  static function template()
  {
    $data = [
      "id"=> "01952e88-e185-4432-a6ec-3e4cdf85b028",
      "ZoneID"=> 4,
      "Name"=> "Logo",
      "UserID"=> "admin",
      "IsPublic"=> true,
      "ObjectType"=> null,
      "IsMigrated"=> true,
      "Description"=> "",
      "IsCorrupt"=> false,
      "LastError"=> null,
      "BackgroundID"=> null,
      "Blocks"=> [
        [
          "BlockType"=> "Picture",
          "OpacityLevel"=> 255,
          "MaintainAspectRatio"=> true,
          "HorizAlignment"=> "Center",
          "VertAlignment"=> "Center",
          "MediaID"=> "243f83f2-1c95-4fbd-9aec-010a8adb2f4f",
          "Height"=> 200,
          "Width"=> 542,
          "X"=> 28,
          "Y"=> 37,
          "RectColor"=> "FFFFFF",
          "RectColorOpacity"=> 0,
          "RectShadow"=> false,
          "RectShadowColor"=> "000000",
          "RectShadowOpacity"=> 255,
          "RectShadowDepth"=> 1,
          "RectOutline"=> false,
          "RectOutlineColor"=> "000000",
          "RectOutlineOpacity"=> 255,
          "RectOutlineWidth"=> 1,
          "RectGradient"=> false,
          "RectGradientMode"=> "Horizontal",
          "RectGradientColor"=> "000000",
          "RectGradientOpacity"=> 255,
          "RotateDegrees"=> 0,
          "Reflection"=> false,
          "ReflectionOpacity"=> 63,
          "ReflectionOffset"=> 0,
          "ReflectionHeight"=> 0.25,
          "Name"=> "Company Logo",
          "HTMLFieldType"=> "EditField",
          "HTMLFieldSize"=> "Small",
          "RepeatType"=> "None"
        ],
        [
          "BlockType"=> "Text",
          "TextBold"=> false,
          "TextItalic"=> false,
          "TextRegular"=> true,
          "TextStrikeout"=> false,
          "TextUnderline"=> false,
          "TextColor"=> "FFFFFF",
          "TextColorOpacity"=> 255,
          "TextGlow"=> false,
          "TextGlowColor"=> "FFFF00",
          "TextShadow"=> false,
          "TextShadowColor"=> "000000",
          "TextShadowOpacity"=> 255,
          "TextShadowDepth"=> 0,
          "TextOutline"=> false,
          "TextOutlineColor"=> "FFFFFF",
          "TextOutlineOpacity"=> 255,
          "TextGradient"=> false,
          "TextGradientMode"=> "Horizontal",
          "TextGradientColor"=> "FFFFFF",
          "TextGradientOpacity"=> 255,
          "TextPadding"=> 0,
          "Text"=> "www.website.com",
          "TextSize"=> 10,
          "TextFont"=> "Arial",
          "TextHorizAlignment"=> "Center",
          "TextVertAlignment"=> "Center",
          "TextVertical"=> false,
          "TextRightToLeft"=> false,
          "TextWrap"=> true,
          "AllowResizeRect"=> true,
          "AutoSizeText"=> true,
          "TextMaxLength"=> -1,
          "TruncateURLs"=> false,
          "Height"=> 37,
          "Width"=> 510,
          "X"=> 43,
          "Y"=> 235,
          "RectColor"=> "FFFFFF",
          "RectColorOpacity"=> 0,
          "RectShadow"=> false,
          "RectShadowColor"=> "000000",
          "RectShadowOpacity"=> 255,
          "RectShadowDepth"=> 1,
          "RectOutline"=> false,
          "RectOutlineColor"=> "000000",
          "RectOutlineOpacity"=> 255,
          "RectOutlineWidth"=> 1,
          "RectGradient"=> false,
          "RectGradientMode"=> "Horizontal",
          "RectGradientColor"=> "000000",
          "RectGradientOpacity"=> 255,
          "RotateDegrees"=> 0,
          "Reflection"=> false,
          "ReflectionOpacity"=> 63,
          "ReflectionOffset"=> 0,
          "ReflectionHeight"=> 0.25,
          "Name"=> "Website",
          "HTMLFieldType"=> "EditField",
          "HTMLFieldSize"=> "Large",
          "RepeatType"=> "None"
        ]
      ],
      "PreviewImageUrl"=> "/Carousel/Media/Templates/01952e88-e185-4432-a6ec-3e4cdf85b028/Preview.jpg",
      "TinyImageUrl"=> "/Carousel/Media/Templates/01952e88-e185-4432-a6ec-3e4cdf85b028/Tiny.jpg",
      "ThumbnailImageUrl"=> "/Carousel/Media/Templates/01952e88-e185-4432-a6ec-3e4cdf85b028/Thumbnail.jpg",
      "FullImageUrl"=> "/Carousel/Media/Templates/01952e88-e185-4432-a6ec-3e4cdf85b028/Final.jpg",
      "BackgroundImageUrl"=> null
    ];

    return json_encode($data);
  }

  static function media()
  {
    $data = [
      [
        "Tags" => [
          [
            "id"=> 1,
            "TagName"=> "Logo",
            "ZoneID"=> 3
          ]
        ],
        "id"=> "1",
        "Type"=> "Picture",
        "ZoneID"=> 3,
        "UserID"=> "admin",
        "IsDeleted"=> false,
        "IsPublic"=> true,
        "Name"=> "A_Logo",
        "PreviewImageUrl"=> "/Carousel/Media/Pictures/dc9cc91e-3c20-4fc9-9f65-6567a87247d0/Preview.jpg",
        "TinyImageUrl"=> "/Carousel/Media/Pictures/dc9cc91e-3c20-4fc9-9f65-6567a87247d0/Tiny.jpg",
        "ThumbnailImageUrl"=> "/Carousel/Media/Pictures/dc9cc91e-3c20-4fc9-9f65-6567a87247d0/Thumbnail.jpg",
        "FullUrl"=> "/Carousel/Media/Pictures/dc9cc91e-3c20-4fc9-9f65-6567a87247d0/Final.png"
      ],
      [
        "Tags" => [
          [
            "id"=> 1,
            "TagName"=> "Logo",
            "ZoneID"=> 3
          ]
        ],
        "id"=> "2",
        "Type"=> "Picture",
        "ZoneID"=> 3,
        "UserID"=> "admin",
        "IsDeleted"=> false,
        "IsPublic"=> true,
        "Name"=> "A_Logo",
        "PreviewImageUrl"=> "/Carousel/Media/Pictures/dc9cc91e-3c20-4fc9-9f65-6567a87247d0/Preview.jpg",
        "TinyImageUrl"=> "/Carousel/Media/Pictures/dc9cc91e-3c20-4fc9-9f65-6567a87247d0/Tiny.jpg",
        "ThumbnailImageUrl"=> "/Carousel/Media/Pictures/dc9cc91e-3c20-4fc9-9f65-6567a87247d0/Thumbnail.jpg",
        "FullUrl"=> "/Carousel/Media/Pictures/dc9cc91e-3c20-4fc9-9f65-6567a87247d0/Final.png"
      ],
    ];
    return json_encode($data);
  }

  static function zones()
  {
    $data = [
      [
        "Tags"=> [
          [
            "id"=> 1,
            "TagName"=> "My First Channel 2017"
          ]
        ],
        "id"=> 1,
        "ZoneName"=> "MFC_2017-News",
        "GraphicsWidth"=> 600,
        "GraphicsHeight"=> 300,
        "DaylightSavings"=> false,
        "ZoneType"=> "Bulletin",
        "Description"=> "",
        "TimezoneID"=> null,
        "EmailEnabled"=> false,
        "EmailAddresses"=> "",
        "Pacing"=> 0.5,
        "DefaultTransition"=> "{3F159212-80AA-48ff-A103-921D56F6E4F5}",
        "PublicRSSActive"=> true,
        "PublicWebActive"=> true,
        "ExcludedWords"=> null,
        "ForceMonitorOn"=> null,
        "IsMigrating"=> false,
        "AlertsActive"=> false
      ],
      [
        "Tags"=> [
          [
            "id"=> 1,
            "TagName"=> "My First Channel 2017"
          ]
        ],
        "id"=> 2,
        "ZoneName"=> "MFC_2017-News",
        "GraphicsWidth"=> 600,
        "GraphicsHeight"=> 300,
        "DaylightSavings"=> false,
        "ZoneType"=> "Bulletin",
        "Description"=> "",
        "TimezoneID"=> null,
        "EmailEnabled"=> false,
        "EmailAddresses"=> "",
        "Pacing"=> 0.5,
        "DefaultTransition"=> "{3F159212-80AA-48ff-A103-921D56F6E4F5}",
        "PublicRSSActive"=> true,
        "PublicWebActive"=> true,
        "ExcludedWords"=> null,
        "ForceMonitorOn"=> null,
        "IsMigrating"=> false,
        "AlertsActive"=> false
      ],
    ];
    return json_encode($data);
  }
}
