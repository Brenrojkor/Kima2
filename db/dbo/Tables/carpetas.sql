-- =====================================================
-- Object:  Table [dbo].[carpetas]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[carpetas] (
	[id] [int] IDENTITY(1,1) NOT NULL PRIMARY KEY,
    [nombre] [nvarchar](255) NOT NULL,
    [fecha_creacion] [datetime] NULL DEFAULT GETDATE(),
    [ruta] [varchar](255) NULL
);